<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Standing;
use App\Models\Store;
use App\Models\Tournament;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class TournamentController extends Controller
{

    public function tournaments(Request $request)
    {
        $user = $request->user();

        if ($user->admin) {
            $tournaments = Tournament::all();
            $stores = Store::all(); // für dropdown zum erstellen neuer turniere

        } else {
            $stores = User::find($user->id)->stores()->get();
            $store_ids = $stores->map(fn ($store) => $store->id);
            $tournaments = Tournament::whereIn('store_id', $store_ids)->get();
        }

        $tournaments = $tournaments->sortByDesc('date');

        $now = new DateTime();

        $upcoming = $tournaments->filter(fn ($tour) => (new DateTime($tour->date)) > $now)->sortBy('date');
        $past = $tournaments->filter(fn ($tour) => (new DateTime($tour->date)) <= $now)->sortByDesc('date');

        return view('admin.tournaments', [
            'upcoming' => $upcoming,
            'past' => $past,
            'stores' => $stores
        ]);
    }

    public function create(Request $request) {
        $user = $request->user();

        // check if user is allowed to create tournament for the given store
        if (!$user->admin) {
            $store_ids = User::find($user->id)->stores()->get()->map(fn ($store) => $store->id);
            if (!in_array($request->input('store_id'), $store_ids->all())) abort(403);
        }

        $tournament = Tournament::create([
            'store_id' => $request->input('store_id'),
            'date' => $request->input('date'),
            'type' => $request->input('type')
        ]);

        return Redirect::route('admin.tournament', [ 'id' => $tournament->id ]);
    }

    // regular users can only edit the stores that they are assigned to
    function checkAuthorization ($request) {
        $tournament = Tournament::find($request->route('id'));
        $user = $request->user();
        $allowed = false;

        if ($user->admin) $allowed = true;
        else {
            $store_ids = User::find($user->id)->stores()->get()->map(fn ($store) => $store->id);
            if (in_array($tournament->store_id, $store_ids->all())) $allowed = true;
        }

        return [ $allowed, $tournament ];
    }

    public function tournament(Request $request) {
        list($allowed, $tournament) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        return view('admin.tournament', [
            'tournament' => $tournament,
            'store' => $tournament->store,
            'registrations' => $tournament->registrations,
            'standings' => $tournament->standings,
            'photos' => $tournament->photos
        ]);
    }

    public function update(Request $request) {
        list($allowed, $tournament) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        $values = $request->all();
        $values['registration'] = $request->has('registration');

        $tournament->fill($values);
        $tournament->save();

        return Redirect::route('admin.tournament', [ 'id' => $tournament->id ])
            ->with('status', 'tournament-updated');
    }

    public function destroy(Request $request) {
        list($allowed, $tournament) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        $tournament->delete();

        return Redirect::route('admin.tournaments')->with('status', 'tournament-deleted');
    }

    public function tdf (Request $request) {
        list($allowed, $tournament) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        $file = $request->file('tdf_file');
        $tdf = simplexml_load_file($file->getRealPath());

        $players = [];
        $standings = [];

        foreach ($tdf->players->player as $player) {
            $id = (int) $player->attributes()['userid'];
            $players[$id] = [
                'first_name' => (string) $player->firstname,
                'last_name' => (string) $player->lastname,
                'wins' => 0,
                'losses' => 0,
                'ties' => 0
            ];
        }

        foreach ($tdf->pods->pod as $pod) {
            foreach ($pod->rounds->round as $round) {
                foreach ($round->matches->match as $match) {
                    $outcome = (int) $match->attributes()['outcome'];

                    if ($outcome === 5) { // bye
                        $id = (int) $match->player->attributes()['userid'];
                        $players[$id]['wins']++;
                    } else {
                        $p1 = (int) $match->player1->attributes()['userid'];
                        $p2 = (int) $match->player2->attributes()['userid'];

                        if ($outcome === 1) {
                            $players[$p1]['wins']++;
                            $players[$p2]['losses']++;
                        } else if ($outcome === 2) {
                            $players[$p1]['losses']++;
                            $players[$p2]['wins']++;
                        } else {
                            $players[$p1]['ties']++;
                            $players[$p2]['ties']++;
                        }
                    }
                }
            }
        }

        foreach ($tdf->standings->pod as $pod) {
            $attr = $pod->attributes();
            if ((string) $attr['type'] === 'dnf' || !$pod->player) continue;
            $division = match((string) $attr['category']) {
                "2" => "MA",
                "0" => "JR",
                default => "SR"
            };

            foreach ($pod->player as $player) {
                $pa = $player->attributes();
                $id = (int) $pa['id'];

                $data = $players[$id];

                if ($division !== 'MA') {
                    $data['last_name'] = substr($data['last_name'], 0, 1) . '.';
                }

                $standings[] = [
                    'tournament_id' => $tournament->id,
                    'division' => $division,
                    'name' => "$data[first_name] $data[last_name]",
                    'playerid' => $id,
                    'place' => (int) $pa['place'],
                    'wins' => $data['wins'],
                    'losses' => $data['losses'],
                    'ties' => $data['ties']
                ];
            }
        }

        Standing::insert($standings);
        $tournament->fill([ 'results' => 1 ]);
        $tournament->save();

        return Redirect::route('admin.tournament', [ 'id' => $tournament->id ]);
    }

    public function deleteResults (Request $request) {
        list($allowed, $tournament) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        $tournament->standings()->delete();
        $tournament->fill([ 'results' => 0 ]);
        $tournament->save();

        return Redirect::route('admin.tournament', [ 'id' => $tournament->id ]);
    }

    public function uploadPhotos (Request $request) {
        list($allowed, $tournament) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        if ($request->hasFile('files')) {

            $photos = [];

            $dir = public_path("upload/tournaments/$tournament->id");
            if (!is_dir($dir)) mkdir($dir);

            foreach ($request->file('files') as $uploadedFile) {

                $img = Image::read($uploadedFile);
                $img->scaleDown(1080, 1080);

                $id = Str::uuid();
                $img->toWebp(80)->save("$dir/$id.webp");

                $photos[] = [
                    'id' => $id,
                    'tournament_id' => $tournament->id
                ];
            }

            Photo::insert($photos);
        }

        return Redirect::route('admin.tournament', [ 'id' => $tournament->id ]);
    }

    public function deletePhoto (Request $request) {
        list($allowed) = $this->checkAuthorization($request);
        if (!$allowed) abort(403);

        Photo::where('id', $request->route('pid'))->delete();

        return response()->json(['status' => 'success']);
    }

}
