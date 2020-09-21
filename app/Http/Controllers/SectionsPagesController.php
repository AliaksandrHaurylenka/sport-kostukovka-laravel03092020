<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Coach;
use App\Pride;

class SectionsPagesController extends Controller
{

	public function section($id, $slug){
		$section = Section::where('id', $id)->firstOrFail();
		$photo_sports = Section::where('id', $id)->firstOrFail();
		$coaches = Coach::where('section_id', $id)->where('work', 'Да')->get();
		$coaches_archive = Coach::where('section_id', $id)->where('work', 'Нет')->latest('id')->get();
		$prides = Pride::where('section_id', $id)->latest('id')->get();

		return view('site.sections.section', compact('section', 'photo_sports', 'coaches', 'coaches_archive', 'prides'));
	}
}
