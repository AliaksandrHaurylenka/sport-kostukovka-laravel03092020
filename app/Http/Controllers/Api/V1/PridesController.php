<?php

namespace App\Http\Controllers\Api\V1;

use App\Pride;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePridesRequest;
use App\Http\Requests\Admin\UpdatePridesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class PridesController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Pride::all();
    }

    public function show($id)
    {
        return Pride::findOrFail($id);
    }

    public function update(UpdatePridesRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $pride = Pride::findOrFail($id);
        $pride->update($request->all());
        

        return $pride;
    }

    public function store(StorePridesRequest $request)
    {
        $request = $this->saveFiles($request);
        $pride = Pride::create($request->all());
        

        return $pride;
    }

    public function destroy($id)
    {
        $pride = Pride::findOrFail($id);
        $pride->delete();
        return '';
    }
}
