<?php

namespace App\Http\Controllers\Admin;

use App\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMainsRequest;
use App\Http\Requests\Admin\UpdateMainsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class MainsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Main.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('main_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('main_delete')) {
                return abort(401);
            }
            $mains = Main::onlyTrashed()->get();
        } else {
            $mains = Main::all();
        }

        return view('admin.mains.index', compact('mains'));
    }

    /**
     * Show the form for creating new Main.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('main_create')) {
            return abort(401);
        }
        return view('admin.mains.create');
    }

    /**
     * Store a newly created Main in storage.
     *
     * @param  \App\Http\Requests\StoreMainsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMainsRequest $request)
    {
        if (! Gate::allows('main_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Main::PATH);
        $main = Main::create($request->all());



        return redirect()->route('admin.mains.index');
    }


    /**
     * Show the form for editing Main.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('main_edit')) {
            return abort(401);
        }
        $main = Main::findOrFail($id);

        return view('admin.mains.edit', compact('main'));
    }

    /**
     * Update Main in storage.
     *
     * @param  \App\Http\Requests\UpdateMainsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMainsRequest $request, $id)
    {
        if (! Gate::allows('main_edit')) {
            return abort(401);
        }

        $request = $this->saveFiles($request, Main::PATH);
        $main = Main::findOrFail($id);
        if($_FILES['photo']['name']){
            $main->removeImg();
        }
        $main->update($request->all());



        return redirect()->route('admin.mains.index');
    }


    /**
     * Remove Main from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('main_delete')) {
            return abort(401);
        }
        $main = Main::findOrFail($id);
        $main->delete();

        return redirect()->route('admin.mains.index');
    }

    /**
     * Delete all selected Main at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('main_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Main::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Main from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('main_delete')) {
            return abort(401);
        }
        $main = Main::onlyTrashed()->findOrFail($id);
        $main->restore();

        return redirect()->route('admin.mains.index');
    }

    /**
     * Permanently delete Main from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('main_delete')) {
            return abort(401);
        }
        Main::onlyTrashed()->findOrFail($id)->remove();


        return redirect()->route('admin.mains.index');
    }
}
