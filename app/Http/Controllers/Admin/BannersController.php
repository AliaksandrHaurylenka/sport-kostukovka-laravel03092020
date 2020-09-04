<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBannersRequest;
use App\Http\Requests\Admin\UpdateBannersRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class BannersController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Banner.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('banner_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('banner_delete')) {
                return abort(401);
            }
            $banners = Banner::onlyTrashed()->get();
        } else {
            $banners = Banner::all();
        }

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating new Banner.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*if (! Gate::allows('banner_create')) {
            return abort(401);
        }*/
        return view('admin.banners.create');
    }

    /**
     * Store a newly created Banner in storage.
     *
     * @param StoreBannersRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBannersRequest $request)
    {
        if (! Gate::allows('banner_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Banner::PATH);
        $banner = Banner::create($request->all());



        return redirect()->route('admin.banners.index');
    }


    /**
     * Show the form for editing Banner.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('banner_edit')) {
            return abort(401);
        }
        $banner = Banner::findOrFail($id);

        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update Banner in storage.
     *
     * @param UpdateBannersRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBannersRequest $request, $id)
    {
        if (! Gate::allows('banner_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Banner::PATH);
        $banner = Banner::findOrFail($id);
        if($_FILES['banner']['name']){
            $banner->removeImg();
        }
        $banner->update($request->all());
        return redirect()->route('admin.banners.index');
    }


    /**
     * Remove Banner from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('banner_delete')) {
            return abort(401);
        }
        $banner = Banner::findOrFail($id);
        $banner->delete();

        return redirect()->route('admin.banners.index');
    }

    /**
     * Delete all selected Banner at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('banner_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Banner::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Banner from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('banner_delete')) {
            return abort(401);
        }
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $banner->restore();

        return redirect()->route('admin.banners.index');
    }

    /**
     * Permanently delete Banner from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('banner_delete')) {
            return abort(401);
        }
        Banner::onlyTrashed()->findOrFail($id)->remove();

        return redirect()->route('admin.banners.index');
    }
}
