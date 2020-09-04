<?php

namespace App\Http\Controllers\Api\V1;

use App\Timetable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTimetablesRequest;
use App\Http\Requests\Admin\UpdateTimetablesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class TimetablesController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Timetable::all();
    }

    public function show($id)
    {
        return Timetable::findOrFail($id);
    }

    public function update(UpdateTimetablesRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $timetable = Timetable::findOrFail($id);
        $timetable->update($request->all());
        

        return $timetable;
    }

    public function store(StoreTimetablesRequest $request)
    {
        $request = $this->saveFiles($request);
        $timetable = Timetable::create($request->all());
        

        return $timetable;
    }

    public function destroy($id)
    {
        $timetable = Timetable::findOrFail($id);
        $timetable->delete();
        return '';
    }
}
