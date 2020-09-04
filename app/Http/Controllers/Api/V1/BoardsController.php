<?php

namespace App\Http\Controllers\Api\V1;

use App\Board;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBoardsRequest;
use App\Http\Requests\Admin\UpdateBoardsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class BoardsController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Board::all();
    }

    public function show($id)
    {
        return Board::findOrFail($id);
    }

    public function update(UpdateBoardsRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $board = Board::findOrFail($id);
        $board->update($request->all());
        

        return $board;
    }

    public function store(StoreBoardsRequest $request)
    {
        $request = $this->saveFiles($request);
        $board = Board::create($request->all());
        

        return $board;
    }

    public function destroy($id)
    {
        $board = Board::findOrFail($id);
        $board->delete();
        return '';
    }
}
