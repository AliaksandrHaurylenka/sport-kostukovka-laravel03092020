<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBannersRequest;
use App\Http\Requests\Admin\UpdateBannersRequest;
// use App\Http\Controllers\Traits\FileUploadTrait;

use App\Http\Controllers\Admin\Obj\CRUDFile;

class BannersController extends Controller
{
    // use FileUploadTrait;

    private $crud;


    public function __construct()
    {
        $this->crud = new CRUDFile('banner', Banner::class);
    }

    public function index()
    {
        $banners = $this->crud->index();
        return view('admin.banners.index', compact('banners'));
    }

    
    public function create()
    {
        $this->crud->create();
        return view('admin.banners.create');
    }

    
    public function store(StoreBannersRequest $request)
    {
        $this->crud->store($request);
        return redirect()->route('admin.banners.index');
    }


    
    public function edit($id)
    {
        $banner = $this->crud->edit($id);
        return view('admin.banners.edit', compact('banner'));
    }

    
    public function update(UpdateBannersRequest $request, $id)
    {
        $this->crud->update_file($request, $id, ['banner']);
        return redirect()->route('admin.banners.index');
    }


    
    public function destroy($id)
    {
        $this->crud->destroy($id);
        return redirect()->route('admin.banners.index');
    }

   
    public function massDestroy(Request $request)
    {
        $this->crud->massDestroy($request);
    }


    
    public function restore($id)
    {
        $this->crud->restore($id);
        return redirect()->route('admin.banners.index');
    }

    
    public function perma_del($id)
    {
        $this->crud->perma_del_file($id, ['banner']);
        return redirect()->route('admin.banners.index');
    }
}
