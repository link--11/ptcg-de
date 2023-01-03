<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{

    public function pages()
    {
        $pages = Page::all();

        return view('admin.pages', [
            'pages' => $pages
        ]);
    }

    // @todo ADMIN ONLY
    public function create(Request $request) {

        $page = Page::create([
            'title' => $request->title
        ]);

        return Redirect::route('admin.page', [ 'id' => $page->id ]);
    }

    public function page(Request $request) {
        $page = Page::find($request->route('id'));

        return view('admin.page', [
            'page' => $page
        ]);
    }

    public function update(Request $request) {
        $page = Page::find($request->route('id'));

        $page->fill($request->all());
        $page->save();

        return Redirect::route('admin.page', [ 'id' => $page->id ])
            ->with('status', 'page-updated');
    }

}
