<?php

namespace App\Http\Controllers\Api\V1;

use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSectionsRequest;
use App\Http\Requests\Admin\UpdateSectionsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class SectionsController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Section::all();
    }

    public function show($id)
    {
        return Section::findOrFail($id);
    }

    public function update(UpdateSectionsRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $section = Section::findOrFail($id);
        $section->update($request->all());
        

        return $section;
    }

    public function store(StoreSectionsRequest $request)
    {
        $request = $this->saveFiles($request);
        $section = Section::create($request->all());
        

        return $section;
    }

    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return '';
    }
}
