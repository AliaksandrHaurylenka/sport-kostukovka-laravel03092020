<?php

namespace App\Http\Controllers\Api\V1;

use App\Poststag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePoststagsRequest;
use App\Http\Requests\Admin\UpdatePoststagsRequest;

class PoststagsController extends Controller
{
    public function index()
    {
        return Poststag::all();
    }

    public function show($id)
    {
        return Poststag::findOrFail($id);
    }

    public function update(UpdatePoststagsRequest $request, $id)
    {
        $poststag = Poststag::findOrFail($id);
        $poststag->update($request->all());
        

        return $poststag;
    }

    public function store(StorePoststagsRequest $request)
    {
        $poststag = Poststag::create($request->all());
        

        return $poststag;
    }

    public function destroy($id)
    {
        $poststag = Poststag::findOrFail($id);
        $poststag->delete();
        return '';
    }
}
