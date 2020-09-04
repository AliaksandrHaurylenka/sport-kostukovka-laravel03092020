<?php

namespace App\Http\Controllers\Api\V1;

use App\Main;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMainsRequest;
use App\Http\Requests\Admin\UpdateMainsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class MainsController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Main::all();
    }

    public function show($id)
    {
        return Main::findOrFail($id);
    }

    public function update(UpdateMainsRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $main = Main::findOrFail($id);
        $main->update($request->all());
        

        return $main;
    }

    public function store(StoreMainsRequest $request)
    {
        $request = $this->saveFiles($request);
        $main = Main::create($request->all());
        

        return $main;
    }

    public function destroy($id)
    {
        $main = Main::findOrFail($id);
        $main->delete();
        return '';
    }
}
