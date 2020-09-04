<?php

namespace App\Http\Controllers\Admin;

use App\Gomelglass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGomelglassesRequest;
use App\Http\Requests\Admin\UpdateGomelglassesRequest;

use App\Http\Controllers\Admin\Obj\CRUDFile;
class GomelglassesController extends Controller
{
    private $crud;
    private $column = 'photo';
    private $indexView = 'admin.gomelglasses.index';
    private $createView = 'admin.gomelglasses.create';
    private $editView = 'admin.gomelglasses.edit';


    public function __construct()
    {
        $this->crud = new CRUDFile('gomelglass', Gomelglass::class);
    }
    

    public function index()
    {
        $gomelglasses = $this->crud->index();
        return view($this->indexView, compact('gomelglasses'));
    }

    
    public function create()
    {
        $this->crud->create();
        return view($this->createView);
    }

    
    public function store(StoreGomelglassesRequest $request)
    {
        $this->crud->store($request);
        return redirect()->route($this->indexView);
    }


    
    public function edit($id)
    { 
        $gomelglass = $this->crud->edit($id);
        return view($this->editView, compact('gomelglass'));
    }

    
    public function update(UpdateGomelglassesRequest $request, $id)
    {
        $this->crud->update_file($request, $id, [$this->column]);
        return redirect()->route($this->indexView);
    }


   
    public function destroy($id)
    {
        $this->crud->destroy($id);
        return redirect()->route($this->indexView);
    }

    
    public function massDestroy(Request $request)
    {
        $this->crud->massDestroy($request);
    }


    
    public function restore($id)
    {
        $this->crud->restore($id);
        return redirect()->route($this->indexView);
    }

    
    public function perma_del($id)
    {
        $this->crud->perma_del_file($id, [$this->column]);
        return redirect()->route($this->indexView);
    }
}
