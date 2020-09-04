<?php

namespace App\Http\Controllers\Api\V1;

use App\Subscribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubscribesRequest;
use App\Http\Requests\Admin\UpdateSubscribesRequest;

class SubscribesController extends Controller
{
    public function index()
    {
        return Subscribe::all();
    }

    public function show($id)
    {
        return Subscribe::findOrFail($id);
    }

    public function update(UpdateSubscribesRequest $request, $id)
    {
        $subscribe = Subscribe::findOrFail($id);
        $subscribe->update($request->all());
        

        return $subscribe;
    }

    public function store(StoreSubscribesRequest $request)
    {
        $subscribe = Subscribe::create($request->all());
        

        return $subscribe;
    }

    public function destroy($id)
    {
        $subscribe = Subscribe::findOrFail($id);
        $subscribe->delete();
        return '';
    }
}
