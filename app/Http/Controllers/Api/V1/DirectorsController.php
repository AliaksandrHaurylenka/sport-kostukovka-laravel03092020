<?php

namespace App\Http\Controllers\Api\V1;

use App\Director;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDirectorsRequest;
use App\Http\Requests\Admin\UpdateDirectorsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class DirectorsController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Director::all();
    }

    public function show($id)
    {
        return Director::findOrFail($id);
    }

    public function update(UpdateDirectorsRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $director = Director::findOrFail($id);
        $director->update($request->all());
        

        return $director;
    }

    public function store(StoreDirectorsRequest $request)
    {
        $request = $this->saveFiles($request);
        $director = Director::create($request->all());
        

        return $director;
    }

    public function destroy($id)
    {
        $director = Director::findOrFail($id);
        $director->delete();
        return '';
    }
}
