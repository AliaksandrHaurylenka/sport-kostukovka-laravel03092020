<?php

namespace App\Http\Controllers\Admin;


use App\Poststag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePoststagsRequest;
use App\Http\Requests\Admin\UpdatePoststagsRequest;


class PoststagsController extends Controller
{
    /**
     * Display a listing of Poststag.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('poststag_access')) {
            return abort(401);
        }
        if (request('show_deleted') == 1) {
            if (! Gate::allows('poststag_delete')) {
                return abort(401);
            }
            $poststags = Poststag::onlyTrashed()->get();
        } else {
            $poststags = Poststag::all();
        }
        return view('admin.poststags.index', compact('poststags'));
    }
    /**
     * Show the form for creating new Poststag.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('poststag_create')) {
            return abort(401);
        }
        return view('admin.poststags.create');
    }

    /**
     * Store a newly created Poststag in storage.
     *
     * @param StorePoststagsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePoststagsRequest $request)
    {
        if (! Gate::allows('poststag_create')) {
            return abort(401);
        }
        $poststag = Poststag::create($request->all());
        return redirect()->route('admin.poststags.index');
    }
    /**
     * Show the form for editing Poststag.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('poststag_edit')) {
            return abort(401);
        }
        $poststag = Poststag::findOrFail($id);
        return view('admin.poststags.edit', compact('poststag'));
    }

    /**
     * Update Poststag in storage.
     *
     * @param UpdatePoststagsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePoststagsRequest $request, $id)
    {
        if (! Gate::allows('poststag_edit')) {
            return abort(401);
        }
        $poststag = Poststag::findOrFail($id);
        $poststag->update($request->all());
        return redirect()->route('admin.poststags.index');
    }
    /**
     * Remove Poststag from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('poststag_delete')) {
            return abort(401);
        }
        $poststag = Poststag::findOrFail($id);
        $poststag->delete();
        return redirect()->route('admin.poststags.index');
    }
    /**
     * Delete all selected Poststag at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('poststag_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Poststag::whereIn('id', $request->input('ids'))->get();
            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
    /**
     * Restore Poststag from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('poststag_delete')) {
            return abort(401);
        }
        $poststag = Poststag::onlyTrashed()->findOrFail($id);
        $poststag->restore();
        return redirect()->route('admin.poststags.index');
    }
    /**
     * Permanently delete Poststag from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('poststag_delete')) {
            return abort(401);
        }
        $poststag = Poststag::onlyTrashed()->findOrFail($id);
        $poststag->forceDelete();
        return redirect()->route('admin.poststags.index');
    }
}
