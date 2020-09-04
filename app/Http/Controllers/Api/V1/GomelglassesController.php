<?php

namespace App\Http\Controllers\Api\V1;

use App\Gomelglass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGomelglassesRequest;
use App\Http\Requests\Admin\UpdateGomelglassesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class GomelglassesController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Gomelglass::all();
    }

    public function show($id)
    {
        return Gomelglass::findOrFail($id);
    }

    public function update(UpdateGomelglassesRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $gomelglass = Gomelglass::findOrFail($id);
        $gomelglass->update($request->all());
        

        return $gomelglass;
    }

    public function store(StoreGomelglassesRequest $request)
    {
        $request = $this->saveFiles($request);
        $gomelglass = Gomelglass::create($request->all());
        

        return $gomelglass;
    }

    public function destroy($id)
    {
        $gomelglass = Gomelglass::findOrFail($id);
        $gomelglass->delete();
        return '';
    }
}
