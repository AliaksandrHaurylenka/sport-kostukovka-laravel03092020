<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timetable;

class TimetablesController extends Controller
{
    public function index()
    {
    	$timetable = Timetable::all();
        return view('site.timetable', compact('timetable'));
    }
}
