<?php

namespace App\Http\Controllers\Api\V1;

use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServicesRequest;
use App\Http\Requests\Admin\UpdateServicesRequest;

class ServicesController extends Controller
{
    public function index()
    {
        return Service::all();
    }

    public function show($id)
    {
        return Service::findOrFail($id);
    }

    public function update(UpdateServicesRequest $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->all());
        

        return $service;
    }

    public function store(StoreServicesRequest $request)
    {
        $service = Service::create($request->all());
        

        return $service;
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return '';
    }
}
