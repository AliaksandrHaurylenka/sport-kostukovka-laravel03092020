<?php

namespace App\Http\Controllers\Api\V1;

use App\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHistoriesRequest;
use App\Http\Requests\Admin\UpdateHistoriesRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class HistoriesController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return History::all();
    }

    public function show($id)
    {
        return History::findOrFail($id);
    }

    public function update(UpdateHistoriesRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $history = History::findOrFail($id);
        $history->update($request->all());
        

        return $history;
    }

    public function store(StoreHistoriesRequest $request)
    {
        $request = $this->saveFiles($request);
        $history = History::create($request->all());
        

        return $history;
    }

    public function destroy($id)
    {
        $history = History::findOrFail($id);
        $history->delete();
        return '';
    }
}
