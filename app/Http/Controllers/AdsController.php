<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ad;

class AdsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /*$ads = Ad::where('status', 1)
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(1);

        return view('site.ads', compact('ads'));*/
        
        $msg = "This is a simple message.";
     	return response()->json(array('msg'=> $msg), 200);
    }
}
