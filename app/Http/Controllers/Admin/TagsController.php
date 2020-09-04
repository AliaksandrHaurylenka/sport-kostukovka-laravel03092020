<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTagsRequest;
use App\Http\Requests\Admin\UpdateTagsRequest;

class TagsController extends Controller
{
    /**
     * Display a listing of Tag.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('tag_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('tag_delete')) {
                return abort(401);
            }
            $tags = Tag::onlyTrashed()->get();
        } else {
            $tags = Tag::all();
        }

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating new Tag.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('tag_create')) {
            return abort(401);
        }
        return view('admin.tags.create');
    }

    /**
     * Store a newly created Tag in storage.
     *
     * @param  \App\Http\Requests\StoreTagsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagsRequest $request)
    {
        if (! Gate::allows('tag_create')) {
            return abort(401);
        }
        $tag = Tag::create($request->all());



        return redirect()->route('admin.tags.index');
    }


    /**
     * Show the form for editing Tag.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('tag_edit')) {
            return abort(401);
        }
        $tag = Tag::findOrFail($id);

        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update Tag in storage.
     *
     * @param  \App\Http\Requests\UpdateTagsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagsRequest $request, $id)
    {
        if (! Gate::allows('tag_edit')) {
            return abort(401);
        }
        $tag = Tag::findOrFail($id);
        $tag->slug = null;//для обновления поля slug
        $tag->update($request->all());



        return redirect()->route('admin.tags.index');
    }


    /**
     * Remove Tag from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('tag_delete')) {
            return abort(401);
        }
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.tags.index');
    }

    /**
     * Delete all selected Tag at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('tag_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Tag::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Tag from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('tag_delete')) {
            return abort(401);
        }
        $tag = Tag::onlyTrashed()->findOrFail($id);
        $tag->restore();

        return redirect()->route('admin.tags.index');
    }

    /**
     * Permanently delete Tag from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('tag_delete')) {
            return abort(401);
        }
        $tag = Tag::onlyTrashed()->findOrFail($id);
        $tag->forceDelete();

        return redirect()->route('admin.tags.index');
    }
}
