<?php

namespace App\Http\Controllers\Admin;

use App\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHistoriesRequest;
use App\Http\Requests\Admin\UpdateHistoriesRequest;
//use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Controllers\Traits\FileUploadPostTrait;

class HistoriesController extends Controller
{
    //use FileUploadTrait;
    use FileUploadPostTrait;

    /**
     * Display a listing of History.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('history_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('history_delete')) {
                return abort(401);
            }
            $histories = History::onlyTrashed()->get();
        } else {
            $histories = History::all();
        }

        return view('admin.histories.index', compact('histories'));
    }

    /**
     * Show the form for creating new History.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('history_create')) {
            return abort(401);
        }
        return view('admin.histories.create');
    }

    /**
     * Store a newly created History in storage.
     *
     * @param StoreHistoriesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHistoriesRequest $request)
    {
        if (! Gate::allows('history_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, History::PATH, 800, 450);
        $history = History::create($request->all());



        return redirect()->route('admin.histories.index');
    }


    /**
     * Show the form for editing History.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('history_edit')) {
            return abort(401);
        }
        $history = History::findOrFail($id);

        return view('admin.histories.edit', compact('history'));
    }

    /**
     * Update History in storage.
     *
     * @param UpdateHistoriesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHistoriesRequest $request, $id)
    {
        if (! Gate::allows('history_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, History::PATH, 800, 450);
        $history = History::findOrFail($id);
        if($_FILES['photo']['name']){
            $history->removeImg();
        }
        $history->update($request->all());



        return redirect()->route('admin.histories.index');
    }


    /**
     * Remove History from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('history_delete')) {
            return abort(401);
        }
        $history = History::findOrFail($id);
        $history->delete();

        return redirect()->route('admin.histories.index');
    }

    /**
     * Delete all selected History at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('history_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = History::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore History from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('history_delete')) {
            return abort(401);
        }
        $history = History::onlyTrashed()->findOrFail($id);
        $history->restore();

        return redirect()->route('admin.histories.index');
    }

    /**
     * Permanently delete History from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('history_delete')) {
            return abort(401);
        }
        History::onlyTrashed()->findOrFail($id)->remove();


        return redirect()->route('admin.histories.index');
    }
}
