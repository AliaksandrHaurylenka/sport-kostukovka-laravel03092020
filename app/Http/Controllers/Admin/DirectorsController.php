<?php

namespace App\Http\Controllers\Admin;

use App\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDirectorsRequest;
use App\Http\Requests\Admin\UpdateDirectorsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class DirectorsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Director.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('director_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('director_delete')) {
                return abort(401);
            }
            $directors = Director::onlyTrashed()->get();
        } else {
            $directors = Director::all();
        }

        return view('admin.directors.index', compact('directors'));
    }

    /**
     * Show the form for creating new Director.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('director_create')) {
            return abort(401);
        }
        return view('admin.directors.create');
    }

    /**
     * Store a newly created Director in storage.
     *
     * @param  \App\Http\Requests\StoreDirectorsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDirectorsRequest $request)
    {
        if (! Gate::allows('director_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Director::PATH);
        $director = Director::create($request->all());



        return redirect()->route('admin.directors.index');
    }


    /**
     * Show the form for editing Director.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('director_edit')) {
            return abort(401);
        }
        $director = Director::findOrFail($id);

        return view('admin.directors.edit', compact('director'));
    }

    /**
     * Update Director in storage.
     *
     * @param  \App\Http\Requests\UpdateDirectorsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDirectorsRequest $request, $id)
    {
        if (! Gate::allows('director_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Director::PATH);
        $director = Director::findOrFail($id);
        if($_FILES['photo']['name']){
            $director->removeImg();
        }
        $director->update($request->all());



        return redirect()->route('admin.directors.index');
    }


    /**
     * Remove Director from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('director_delete')) {
            return abort(401);
        }
        $director = Director::findOrFail($id);
        $director->delete();

        return redirect()->route('admin.directors.index');
    }

    /**
     * Delete all selected Director at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('director_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Director::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Director from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('director_delete')) {
            return abort(401);
        }
        $director = Director::onlyTrashed()->findOrFail($id);
        $director->restore();

        return redirect()->route('admin.directors.index');
    }

    /**
     * Permanently delete Director from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('director_delete')) {
            return abort(401);
        }
        Director::onlyTrashed()->findOrFail($id)->remove();

        return redirect()->route('admin.directors.index');
    }
}
