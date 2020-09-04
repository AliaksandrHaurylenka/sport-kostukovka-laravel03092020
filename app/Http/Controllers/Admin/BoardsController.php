<?php

namespace App\Http\Controllers\Admin;

use App\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBoardsRequest;
use App\Http\Requests\Admin\UpdateBoardsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class BoardsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Board.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('board_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('board_delete')) {
                return abort(401);
            }
            $boards = Board::onlyTrashed()->get();
        } else {
            $boards = Board::all();
        }

        return view('admin.boards.index', compact('boards'));
    }

    /**
     * Show the form for creating new Board.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('board_create')) {
            return abort(401);
        }
        return view('admin.boards.create');
    }

    /**
     * Store a newly created Board in storage.
     *
     * @param  \App\Http\Requests\StoreBoardsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBoardsRequest $request)
    {
        if (! Gate::allows('board_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Board::PATH);
        $board = Board::create($request->all());



        return redirect()->route('admin.boards.index');
    }


    /**
     * Show the form for editing Board.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('board_edit')) {
            return abort(401);
        }
        $board = Board::findOrFail($id);

        return view('admin.boards.edit', compact('board'));
    }

    /**
     * Update Board in storage.
     *
     * @param  \App\Http\Requests\UpdateBoardsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBoardsRequest $request, $id)
    {
        if (! Gate::allows('board_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Board::PATH);
        $board = Board::findOrFail($id);
        if($_FILES['photo']['name']){
            $board->removeImg();
        }
        $board->update($request->all());



        return redirect()->route('admin.boards.index');
    }


    /**
     * Remove Board from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('board_delete')) {
            return abort(401);
        }
        $board = Board::findOrFail($id);
        $board->delete();

        return redirect()->route('admin.boards.index');
    }

    /**
     * Delete all selected Board at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('board_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Board::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Board from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('board_delete')) {
            return abort(401);
        }
        $board = Board::onlyTrashed()->findOrFail($id);
        $board->restore();

        return redirect()->route('admin.boards.index');
    }

    /**
     * Permanently delete Board from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('board_delete')) {
            return abort(401);
        }
        Board::onlyTrashed()->findOrFail($id)->remove();


        return redirect()->route('admin.boards.index');
    }
}
