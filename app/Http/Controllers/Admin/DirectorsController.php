<?php

namespace App\Http\Controllers\Admin;

use App\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDirectorsRequest;
use App\Http\Requests\Admin\UpdateDirectorsRequest;

use App\Http\Controllers\Admin\Obj\CRUDFile;
class DirectorsController extends Controller
{
    
    private $crud;


    public function __construct()
    {
        $this->crud = new CRUDFile('director', Director::class);
    }


    public function index()
    {
        $directors = $this->crud->index();
        return view('admin.directors.index', compact('directors'));
    }

    
    public function create()
    {
        $this->crud->create();
        return view('admin.directors.create');
    }

    
    public function store(StoreDirectorsRequest $request)
    {
        $this->crud->store($request);
        return redirect()->route('admin.directors.index');
    }


    
    public function edit($id)
    {
        $director = $this->crud->edit($id);
        return view('admin.directors.edit', compact('director'));
    }

    
    public function update(UpdateDirectorsRequest $request, $id)
    {
        $this->crud->update_file($request, $id, ['photo']);
        return redirect()->route('admin.directors.index');
    }


    
    public function destroy($id)
    {
        $this->crud->destroy($id);
        return redirect()->route('admin.directors.index');
    }

    
    public function massDestroy(Request $request)
    {
        $this->crud->massDestroy($request);
    }


    
    public function restore($id)
    {
        $this->crud->restore($id);
        return redirect()->route('admin.directors.index');
    }

    
    public function perma_del($id)
    {
        $this->crud->perma_del_file($id, ['photo']);
        return redirect()->route('admin.directors.index');
    }
}
