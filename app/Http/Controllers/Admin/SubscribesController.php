<?php

namespace App\Http\Controllers\Admin;

use App\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubscribesRequest;
use App\Http\Requests\Admin\UpdateSubscribesRequest;

class SubscribesController extends Controller
{
    /**
     * Display a listing of Subscribe.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('subscribe_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('subscribe_delete')) {
                return abort(401);
            }
            $subscribes = Subscribe::onlyTrashed()->get();
        } else {
            $subscribes = Subscribe::all();
        }

        return view('admin.subscribes.index', compact('subscribes'));
    }

    /**
     * Show the form for creating new Subscribe.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('subscribe_create')) {
            return abort(401);
        }
        return view('admin.subscribes.create');
    }

    /**
     * Store a newly created Subscribe in storage.
     *
     * @param StoreSubscribesRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscribesRequest $request)
    {
        if (! Gate::allows('subscribe_create')) {
            return abort(401);
        }
        $subscribe = Subscribe::create($request->all());



        return redirect()->route('admin.subscribes.index');
    }


    /**
     * Show the form for editing Subscribe.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('subscribe_edit')) {
            return abort(401);
        }
        $subscribe = Subscribe::findOrFail($id);

        return view('admin.subscribes.edit', compact('subscribe'));
    }

    /**
     * Update Subscribe in storage.
     *
     * @param UpdateSubscribesRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscribesRequest $request, $id)
    {
        if (! Gate::allows('subscribe_edit')) {
            return abort(401);
        }
        $subscribe = Subscribe::findOrFail($id);
        $subscribe->update($request->all());



        return redirect()->route('admin.subscribes.index');
    }


    /**
     * Remove Subscribe from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('subscribe_delete')) {
            return abort(401);
        }
        $subscribe = Subscribe::findOrFail($id);
        $subscribe->delete();

        return redirect()->route('admin.subscribes.index');
    }

    /**
     * Delete all selected Subscribe at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('subscribe_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Subscribe::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Subscribe from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('subscribe_delete')) {
            return abort(401);
        }
        $subscribe = Subscribe::onlyTrashed()->findOrFail($id);
        $subscribe->restore();

        return redirect()->route('admin.subscribes.index');
    }

    /**
     * Permanently delete Subscribe from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('subscribe_delete')) {
            return abort(401);
        }
        $subscribe = Subscribe::onlyTrashed()->findOrFail($id);
        $subscribe->forceDelete();

        return redirect()->route('admin.subscribes.index');
    }
}
