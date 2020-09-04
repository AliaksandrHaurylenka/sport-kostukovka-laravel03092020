<?php

namespace App\Http\Controllers\Admin;

use App\Ad;
use App\Subscribe;
use App\User;
use App\FoldersSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdsRequest;
use App\Http\Requests\Admin\UpdateAdsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;


class AdsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Ad.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('ad_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('ad_delete')) {
                return abort(401);
            }
            $ads = Ad::onlyTrashed()->get();
        } else {
            if(Auth::user()->role_id == 2){
                $ads = Ad::where('user_id', Auth::user()->id)->get();
            }
            else {
                $ads = Ad::all();
            }
        }

        return view('admin.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating new Ad.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('ad_create')) {
            return abort(401);
        }

        if (Auth::user()->role_id == 2){
            FoldersSystem::add_folder_for_img(User::ADS_PATH.Auth::user()->name.'/Ad_N_', Ad::max('id')+1);
        }
        else{
            FoldersSystem::add_folder_for_img(Ad::PATH . 'Ad_N_', Ad::max('id')+1);
        }


        return view('admin.ads.create');
    }

    /**
     * Store a newly created Ad in storage.
     *
     * @param StoreAdsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdsRequest $request)
    {
        if (! Gate::allows('ad_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Ad::PATH);

        $ad = Ad::add($request->all());
        $ad->toggleStatus($request->get('status'));

        User::mailNotification($ad);
        Subscribe::mailNotification($ad);

        return redirect()->route('admin.ads.index');
    }


    /**
     * Show the form for editing Ad.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('ad_edit')) {
            return abort(401);
        }

        if (Auth::user()->role_id == 2){
            FoldersSystem::add_folder_for_img_edit($id, User::ADS_PATH.Auth::user()->name.'/', Ad::where('id', $id));
        }
        else{
            FoldersSystem::add_folder_for_img_edit($id, Ad::PATH, Ad::where('id', $id));
        }


        $ad = Ad::findOrFail($id);

        return view('admin.ads.edit', compact('ad'));
    }

    /**
     * Update Ad in storage.
     *
     * @param UpdateAdsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdsRequest $request, $id)
    {
        if (! Gate::allows('ad_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Ad::PATH);
        $ad = Ad::findOrFail($id);
        $ad->slug = null;
        $ad->status = 0;
        if($_FILES['photo']['name']){
            $ad->removeImg();
        }
        $ad->toggleStatus($request->get('status'));
        $ad->edit($request->all());

        User::mailNotification($ad);
        Subscribe::mailNotification($ad);

        return redirect()->route('admin.ads.index');
    }


    /**
     * Remove Ad from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('ad_delete')) {
            return abort(401);
        }
        $ad = Ad::findOrFail($id);
        $ad->delete();

        return redirect()->route('admin.ads.index');
    }

    /**
     * Delete all selected Ad at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('ad_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Ad::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Ad from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('ad_delete')) {
            return abort(401);
        }
        $ad = Ad::onlyTrashed()->findOrFail($id);
        $ad->restore();

        return redirect()->route('admin.ads.index');
    }

    /**
     * Permanently delete Ad from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('ad_delete')) {
            return abort(401);
        }
        
        $user = new Ad();
        //dd($user->author()->name);

        if (Auth::user()->role_id == 2){
            FoldersSystem::del_folder_img($id, 'ads', User::ADS_PATH.Auth::user()->name.'/');
        }
        else{
            FoldersSystem::del_folder_img($id, 'ads', Ad::PATH);
            //FoldersSystem::del_folder_img($id, 'ads', User::ADS_PATH.$user->author()->name.'/');
        }

        Ad::onlyTrashed()->findOrFail($id)->remove();

        return redirect()->route('admin.ads.index');
    }

    /**
     * Запретить/Опубликовать пост
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle($id)
    {
        $ad = Ad::find($id);
        $ad->statusToggle();

        User::mailNotification($ad);
        Subscribe::mailNotification($ad);

        return redirect()->back();
    }
}
