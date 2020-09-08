<?php

namespace App\Http\Controllers\Admin;

use App\Pride;
use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePridesRequest;
use App\Http\Requests\Admin\UpdatePridesRequest;
// use App\Http\Controllers\Traits\FileUploadTrait;
// use App\Http\Controllers\Traits\FileDelTrait;

class PridesController extends Controller
{
    // use FileUploadTrait;
    // use FileDelTrait;

    /**
     * Display a listing of Pride.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('pride_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('pride_delete')) {
                return abort(401);
            }
            $prides = Pride::onlyTrashed()->get();
        } else {
            $prides = Pride::all();
        }

        return view('admin.prides.index', compact('prides'));
    }

    /**
     * Show the form for creating new Pride.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('pride_create')) {
            return abort(401);
        }
        $sections = Section::pluck('title', 'id');
        return view('admin.prides.create', compact('sections'));
    }

    /**
     * Store a newly created Pride in storage.
     *
     * @param StorePridesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePridesRequest $request)
    {
        if (! Gate::allows('pride_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Pride::PATH);
        $pride = Pride::create($request->all());



        return redirect()->route('admin.prides.index');
    }


    /**
     * Show the form for editing Pride.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('pride_edit')) {
            return abort(401);
        }
        $pride = Pride::findOrFail($id);
        $sections = Section::pluck('title', 'id');

        return view('admin.prides.edit', compact('pride', 'sections'));
    }

    /**
     * Update Pride in storage.
     *
     * @param UpdatePridesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePridesRequest $request, $id)
    {
        if (! Gate::allows('pride_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Pride::PATH);
        $pride = Pride::findOrFail($id);
        if($_FILES['photo']['name']){
            $pride->removeImg();
        }
        $pride->update($request->all());



        return redirect()->route('admin.prides.index');
    }


    /**
     * Remove Pride from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('pride_delete')) {
            return abort(401);
        }
        $pride = Pride::findOrFail($id);
        $pride->delete();

        return redirect()->route('admin.prides.index');
    }

    /**
     * Delete all selected Pride at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('pride_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Pride::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Pride from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('pride_delete')) {
            return abort(401);
        }
        $pride = Pride::onlyTrashed()->findOrFail($id);
        $pride->restore();

        return redirect()->route('admin.prides.index');
    }

    /**
     * Permanently delete Pride from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('pride_delete')) {
            return abort(401);
        }
        Pride::onlyTrashed()->findOrFail($id)->remove();

        return redirect()->route('admin.prides.index');
    }
}
