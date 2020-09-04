<?php

namespace App\Http\Controllers\Admin;

use App\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTimetablesRequest;
use App\Http\Requests\Admin\UpdateTimetablesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Controllers\Traits\FileUploadPostTrait;

class TimetablesController extends Controller
{
   // use FileUploadTrait;
    use FileUploadPostTrait;

    /**
     * Display a listing of Timetable.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('timetable_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('timetable_delete')) {
                return abort(401);
            }
            $timetables = Timetable::onlyTrashed()->get();
        } else {
            $timetables = Timetable::all();
        }

        return view('admin.timetables.index', compact('timetables'));
    }

    /**
     * Show the form for creating new Timetable.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('timetable_create')) {
            return abort(401);
        }
        return view('admin.timetables.create');
    }

    /**
     * Store a newly created Timetable in storage.
     *
     * @param StoreTimetablesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTimetablesRequest $request)
    {
        if (! Gate::allows('timetable_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, '/images/timetable/', 640, 427);
        $timetable = Timetable::create($request->all());



        return redirect()->route('admin.timetables.index');
    }


    /**
     * Show the form for editing Timetable.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('timetable_edit')) {
            return abort(401);
        }
        $timetable = Timetable::findOrFail($id);

        return view('admin.timetables.edit', compact('timetable'));
    }

    /**
     * Update Timetable in storage.
     *
     * @param UpdateTimetablesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTimetablesRequest $request, $id)
    {
        if (! Gate::allows('timetable_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, '/images/timetable/', 640, 427);
        $timetable = Timetable::findOrFail($id);
        if($_FILES['photo']['name']){
            $timetable->removeImg();
        }
        $timetable->update($request->all());



        return redirect()->route('admin.timetables.index');
    }


    /**
     * Remove Timetable from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('timetable_delete')) {
            return abort(401);
        }
        $timetable = Timetable::findOrFail($id);
        $timetable->delete();

        return redirect()->route('admin.timetables.index');
    }

    /**
     * Delete all selected Timetable at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('timetable_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Timetable::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Timetable from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('timetable_delete')) {
            return abort(401);
        }
        $timetable = Timetable::onlyTrashed()->findOrFail($id);
        $timetable->restore();

        return redirect()->route('admin.timetables.index');
    }

    /**
     * Permanently delete Timetable from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('timetable_delete')) {
            return abort(401);
        }
        Timetable::onlyTrashed()->findOrFail($id)->remove();


        return redirect()->route('admin.timetables.index');
    }
}
