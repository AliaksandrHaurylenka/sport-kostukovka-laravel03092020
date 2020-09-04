<?php

namespace App\Http\Controllers\Admin;

use App\Coach;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCoachesRequest;
use App\Http\Requests\Admin\UpdateCoachesRequest;


use App\Http\Controllers\Admin\Obj\CRUDFile;

class CoachesController extends Controller
{
    private $crud;


    public function __construct()
    {
        $this->crud = new CRUDFile('coach', Coach::class);
    }

    
    public function index()
    {
        $coaches = $this->crud->index();
        return view('admin.coaches.index', compact('coaches'));
    }

    
    public function create()
    {
        $this->crud->create();
        $sections = Section::pluck('title', 'id');
        return view('admin.coaches.create', compact('sections'));
    }

    
    public function store(StoreCoachesRequest $request)
    {
        $this->crud->store($request);
        return redirect()->route('admin.coaches.index');
    }


    
    public function edit($id)
    {  
        $coach = $this->crud->edit($id);
        $sections = Section::pluck('title', 'id');
        return view('admin.coaches.edit', compact('coach', 'sections'));
    }

    
    public function update(UpdateCoachesRequest $request, $id)
    {
        $this->crud->update_file($request, $id, ['photo']);
        return redirect()->route('admin.coaches.index');
    }


    
    public function destroy($id)
    {
        $this->crud->destroy($id);
        return redirect()->route('admin.coaches.index');
    }

    
    public function massDestroy(Request $request)
    {
        $this->crud->massDestroy($request);
    }
    


    
    public function restore($id)
    {
        $this->crud->restore($id);
        return redirect()->route('admin.coaches.index');
    }

    
    public function perma_del($id)
    {
        $this->crud->perma_del_file($id, ['photo']);
        return redirect()->route('admin.coaches.index');
    }
}
