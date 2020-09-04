<?php

namespace App\Http\Controllers\Admin;

use App\Gomelglass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGomelglassesRequest;
use App\Http\Requests\Admin\UpdateGomelglassesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class GomelglassesController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Gomelglass.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('gomelglass_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('gomelglass_delete')) {
                return abort(401);
            }
            $gomelglasses = Gomelglass::onlyTrashed()->get();
        } else {
            $gomelglasses = Gomelglass::all()->reverse();
        }

        return view('admin.gomelglasses.index', compact('gomelglasses'));
    }

    /**
     * Show the form for creating new Gomelglass.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('gomelglass_create')) {
            return abort(401);
        }
        return view('admin.gomelglasses.create');
    }

    /**
     * Store a newly created Gomelglass in storage.
     *
     * @param StoreGomelglassesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGomelglassesRequest $request)
    {
        if (! Gate::allows('gomelglass_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Gomelglass::PATH);
        $gomelglass = Gomelglass::create($request->all());



        return redirect()->route('admin.gomelglasses.index');
    }


    /**
     * Show the form for editing Gomelglass.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('gomelglass_edit')) {
            return abort(401);
        }
        $gomelglass = Gomelglass::findOrFail($id);

        return view('admin.gomelglasses.edit', compact('gomelglass'));
    }

    /**
     * Update Gomelglass in storage.
     *
     * @param UpdateGomelglassesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGomelglassesRequest $request, $id)
    {
        if (! Gate::allows('gomelglass_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Gomelglass::PATH);
        $gomelglass = Gomelglass::findOrFail($id);
        if($_FILES['photo']['name']){
            $gomelglass->removeImg();
        }
        $gomelglass->update($request->all());



        return redirect()->route('admin.gomelglasses.index');
    }


    /**
     * Remove Gomelglass from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('gomelglass_delete')) {
            return abort(401);
        }
        $gomelglass = Gomelglass::findOrFail($id);
        $gomelglass->delete();

        return redirect()->route('admin.gomelglasses.index');
    }

    /**
     * Delete all selected Gomelglass at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('gomelglass_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Gomelglass::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Gomelglass from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('gomelglass_delete')) {
            return abort(401);
        }
        $gomelglass = Gomelglass::onlyTrashed()->findOrFail($id);
        $gomelglass->restore();

        return redirect()->route('admin.gomelglasses.index');
    }

    /**
     * Permanently delete Gomelglass from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('gomelglass_delete')) {
            return abort(401);
        }
        Gomelglass::onlyTrashed()->findOrFail($id)->remove();

        return redirect()->route('admin.gomelglasses.index');
    }
}
