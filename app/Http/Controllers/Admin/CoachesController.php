<?php

namespace App\Http\Controllers\Admin;

use App\Coach;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCoachesRequest;
use App\Http\Requests\Admin\UpdateCoachesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;


class CoachesController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Coach.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('coach_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('coach_delete')) {
                return abort(401);
            }
            $coaches = Coach::onlyTrashed()->get();
        } else {
            $coaches = Coach::all();
        }

        return view('admin.coaches.index', compact('coaches'));
    }

    /**
     * Show the form for creating new Coach.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('coach_create')) {
            return abort(401);
        }
        $sections = Section::pluck('title', 'id');
        return view('admin.coaches.create', compact('sections'));
    }

    /**
     * Store a newly created Coach in storage.
     *
     * @param StoreCoachesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoachesRequest $request)
    {
        if (! Gate::allows('coach_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Coach::PATH);
        $coach = Coach::create($request->all());



        return redirect()->route('admin.coaches.index');
    }


    /**
     * Show the form for editing Coach.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('coach_edit')) {
            return abort(401);
        }
        $coach = Coach::findOrFail($id);
        $sections = Section::pluck('title', 'id');
        return view('admin.coaches.edit', compact('coach', 'sections'));
    }

    /**
     * Update Coach in storage.
     *
     * @param UpdateCoachesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoachesRequest $request, $id)
    {
        if (! Gate::allows('coach_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Coach::PATH);
        $coach = Coach::findOrFail($id);
        if($_FILES['photo']['name']){
            $coach->removeImg();
        }
        $coach->update($request->all());



        return redirect()->route('admin.coaches.index');
    }


    /**
     * Remove Coach from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('coach_delete')) {
            return abort(401);
        }
        $coach = Coach::findOrFail($id);
        $coach->delete();

        return redirect()->route('admin.coaches.index');
    }

    /**
     * Delete all selected Coach at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('coach_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Coach::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Coach from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('coach_delete')) {
            return abort(401);
        }
        $coach = Coach::onlyTrashed()->findOrFail($id);
        $coach->restore();

        return redirect()->route('admin.coaches.index');
    }

    /**
     * Permanently delete Coach from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('coach_delete')) {
            return abort(401);
        }
        Coach::onlyTrashed()->findOrFail($id)->remove();


        return redirect()->route('admin.coaches.index');
    }
}
