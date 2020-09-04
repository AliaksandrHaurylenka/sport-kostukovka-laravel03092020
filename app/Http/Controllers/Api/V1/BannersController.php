<?php

namespace App\Http\Controllers\Api\V1;

use App\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBannersRequest;
use App\Http\Requests\Admin\UpdateBannersRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class BannersController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Banner::all();
    }

    public function show($id)
    {
        return Banner::findOrFail($id);
    }

    public function update(UpdateBannersRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $banner = Banner::findOrFail($id);
        $banner->update($request->all());
        

        return $banner;
    }

    public function store(StoreBannersRequest $request)
    {
        $request = $this->saveFiles($request);
        $banner = Banner::create($request->all());
        

        return $banner;
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return '';
    }
}
