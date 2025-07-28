<x-admin-layout title="Turniere">

    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <h2 class="p-4 text-xl font-bold">Bevorstehende Turniere</h2>
        <div class="px-5 py-3 text-gray-900">

            <x-primary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add-new-tournament')">Turnier hinzufügen</x-primary-button>

            <x-modal name="add-new-tournament" focusable>
                <form method="post" action="{{ route('admin.tournaments.create') }}" class="flex flex-col gap-3 p-6">
                    @csrf

                    <div>
                        <x-input-label for="store_id" value="Store" />
                        <x-selection id="store_id" name="store_id" class="block w-full mt-1">
                            @foreach ($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }} {{ $store->city }}</option>
                            @endforeach
                        </x-selection>
                    </div>

                    <div>
                        <x-input-label for="date" value="Datum & Zeit" />
                        <input class="block w-full mt-1 input" type="datetime-local" step=900 id="date" name="date">
                    </div>

                    <x-tournament-selection />

                    <div class="flex justify-end gap-2 mt-2">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </x-modal>

        </div>

        <table class="w-full">
            <tr>
                <th>Datum</th>
                <th>Turniertyp</th>
                <th>Store</th>
            </tr>

            @foreach ($upcoming as $tournament)
                <tr>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ $tournament->date }}</a></td>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ tournament_name($tournament) }}</a></td>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ $tournament->store->name }} {{ $tournament->store->city }}</a></td>
                </tr>

            @endforeach
        </table>

    </div>

    <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <h2 class="p-4 text-xl font-bold">Vergangene Turniere</h2>
        <table class="w-full">
            <tr>
                <th>Datum</th>
                <th>Turniertyp</th>
                <th>Store</th>
            </tr>

            @foreach ($past as $tournament)
                <tr>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ $tournament->date }}</a></td>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ tournament_name($tournament) }}</a></td>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ $tournament->store->name }} {{ $tournament->store->city }}</a></td>
                </tr>

            @endforeach
        </table>
    </div>

</x-admin-layout>
