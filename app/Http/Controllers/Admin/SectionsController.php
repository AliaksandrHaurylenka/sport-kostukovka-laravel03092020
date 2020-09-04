<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSectionsRequest;
use App\Http\Requests\Admin\UpdateSectionsRequest;
//use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Controllers\Traits\FileUploadPostTrait;

class SectionsController extends Controller
{
    //use FileUploadTrait;
    use FileUploadPostTrait;

    /**
     * Display a listing of Section.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('section_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('section_delete')) {
                return abort(401);
            }
            $sections = Section::onlyTrashed()->get();
        } else {
            $sections = Section::all();
        }

        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating new Section.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('section_create')) {
            return abort(401);
        }
        return view('admin.sections.create');
    }

    /**
     * Store a newly created Section in storage.
     *
     * @param StoreSectionsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSectionsRequest $request)
    {
        if (! Gate::allows('section_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, '/images/sections', 800, 450);
        $section = Section::create($request->all());

        return redirect()->route('admin.sections.index');
    }


    /**
     * Show the form for editing Section.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('section_edit')) {
            return abort(401);
        }
        $section = Section::findOrFail($id);
        return view('admin.sections.edit', compact('section'));
    }

    /**
     * Update Section in storage.
     *
     * @param UpdateSectionsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSectionsRequest $request, $id)
    {
        if (! Gate::allows('section_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, '/images/sections/', 800, 450);
        $section = Section::findOrFail($id);
        $section->slug = null;//для обновления поля slug
        if($_FILES['photo']['name']){
            $section->removeImg();
        }
        $section->update($request->all());
        return redirect()->route('admin.sections.index');
    }


    /**
     * Remove Section from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('section_delete')) {
            return abort(401);
        }
        $section = Section::findOrFail($id);
//        Section::findOrFail($id)->remove();
        $section->delete();
        return redirect()->route('admin.sections.index');
    }

    /**
     * Delete all selected Section at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('section_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Section::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Section from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('section_delete')) {
            return abort(401);
        }
        $section = Section::onlyTrashed()->findOrFail($id);
        $section->restore();

        return redirect()->route('admin.sections.index');
    }

    /**
     * Permanently delete Section from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('section_delete')) {
            return abort(401);
        }

        Section::onlyTrashed()->findOrFail($id)->remove();

        return redirect()->route('admin.sections.index');
    }
}
