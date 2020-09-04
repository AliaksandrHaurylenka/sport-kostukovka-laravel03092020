<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMenusRequest;
use App\Http\Requests\Admin\UpdateMenusRequest;

class MenusController extends Controller
{
    /**
     * Display a listing of Menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('menu_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('menu_delete')) {
                return abort(401);
            }
            $menus = Menu::onlyTrashed()->get();
        } else {
            $menus = Menu::all();
        }

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating new Menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('menu_create')) {
            return abort(401);
        }
        return view('admin.menus.create');
    }

    /**
     * Store a newly created Menu in storage.
     *
     * @param StoreMenusRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenusRequest $request)
    {
        if (! Gate::allows('menu_create')) {
            return abort(401);
        }
        $menu = Menu::create($request->all());



        return redirect()->route('admin.menus.index');
    }


    /**
     * Show the form for editing Menu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('menu_edit')) {
            return abort(401);
        }
        $menu = Menu::findOrFail($id);

        return view('admin.menus.edit', compact('menu'));
    }

    /**
     * Update Menu in storage.
     *
     * @param UpdateMenusRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenusRequest $request, $id)
    {
        if (! Gate::allows('menu_edit')) {
            return abort(401);
        }
        $menu = Menu::findOrFail($id);
        $menu->update($request->all());



        return redirect()->route('admin.menus.index');
    }


    /**
     * Remove Menu from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('menu_delete')) {
            return abort(401);
        }
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menus.index');
    }

    /**
     * Delete all selected Menu at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('menu_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Menu::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Menu from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('menu_delete')) {
            return abort(401);
        }
        $menu = Menu::onlyTrashed()->findOrFail($id);
        $menu->restore();

        return redirect()->route('admin.menus.index');
    }

    /**
     * Permanently delete Menu from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('menu_delete')) {
            return abort(401);
        }
        $menu = Menu::onlyTrashed()->findOrFail($id);
        $menu->forceDelete();

        return redirect()->route('admin.menus.index');
    }
}
