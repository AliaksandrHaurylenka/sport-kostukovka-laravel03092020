<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServicesRequest;
use App\Http\Requests\Admin\UpdateServicesRequest;

class ServicesController extends Controller
{
    /**
     * Display a listing of Service.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('service_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('service_delete')) {
                return abort(401);
            }
            $services = Service::onlyTrashed()->get();
        } else {
            $services = Service::all();
        }

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating new Service.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('service_create')) {
            return abort(401);
        }
        return view('admin.services.create');
    }

    /**
     * Store a newly created Service in storage.
     *
     * @param  \App\Http\Requests\StoreServicesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicesRequest $request)
    {
        if (! Gate::allows('service_create')) {
            return abort(401);
        }
        $service = Service::create($request->all());



        return redirect()->route('admin.services.index');
    }


    /**
     * Show the form for editing Service.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('service_edit')) {
            return abort(401);
        }
        $service = Service::findOrFail($id);

        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update Service in storage.
     *
     * @param  \App\Http\Requests\UpdateServicesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServicesRequest $request, $id)
    {
        if (! Gate::allows('service_edit')) {
            return abort(401);
        }
        $service = Service::findOrFail($id);
        $service->update($request->all());



        return redirect()->route('admin.services.index');
    }


    /**
     * Remove Service from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('service_delete')) {
            return abort(401);
        }
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index');
    }

    /**
     * Delete all selected Service at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('service_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Service::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Service from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('service_delete')) {
            return abort(401);
        }
        $service = Service::onlyTrashed()->findOrFail($id);
        $service->restore();

        return redirect()->route('admin.services.index');
    }

    /**
     * Permanently delete Service from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('service_delete')) {
            return abort(401);
        }
        $service = Service::onlyTrashed()->findOrFail($id);
        $service->forceDelete();

        return redirect()->route('admin.services.index');
    }
}
