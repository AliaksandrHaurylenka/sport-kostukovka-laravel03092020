<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Section;
use App\Coach;
use App\Pride;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
    public function action_sections($section, $view, $section_id){
    	
    	$photo_sports = Section::where('title', $section)->get();
    	$coaches = Coach::where('section_id', $section_id)->where('work', 'Да')->get();
    	$coaches_archive = Coach::where('section_id', $section_id)->where('work', 'Нет')->latest('id')->get();
    	$prides = Pride::where('section_id', $section_id)->latest('id')->get();
    	
		return view($view, compact('photo_sports', 'coaches', 'coaches_archive', 'prides'));
	}
}
