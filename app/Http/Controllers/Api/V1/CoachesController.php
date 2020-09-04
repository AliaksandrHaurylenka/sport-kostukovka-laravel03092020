<?php

namespace App\Http\Controllers\Api\V1;

use App\Coach;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCoachesRequest;
use App\Http\Requests\Admin\UpdateCoachesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class CoachesController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Coach::all();
    }

    public function show($id)
    {
        return Coach::findOrFail($id);
    }

    public function update(UpdateCoachesRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $coach = Coach::findOrFail($id);
        $coach->update($request->all());
        

        return $coach;
    }

    public function store(StoreCoachesRequest $request)
    {
        $request = $this->saveFiles($request);
        $coach = Coach::create($request->all());
        

        return $coach;
    }

    public function destroy($id)
    {
        $coach = Coach::findOrFail($id);
        $coach->delete();
        return '';
    }
}
