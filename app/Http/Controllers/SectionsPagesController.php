<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Coach;

class SectionsPagesController extends Controller
{

	public function section($id, $slug){
		$section = Section::where('id', $id)->firstOrFail();
		$photo_sports = Section::where('id', $id)->firstOrFail();
		$coaches = Coach::where('section_id', $id)->where('work', 'Да')->get();
		// dd($coaches);

		return view('site.sections.section', compact('section', 'photo_sports', 'coaches'));
	}




    public function swimming(){
    	
    	return parent::action_sections('Плавание', 'site.sections.swimming', 1);
	}
	
	public function wrestling(){
    	
    	/*$photo_sports = Section::where('title', 'Борьба')->get();
    	
		return view('site.sections.swimming', compact('photo_sports'));*/
		
		return parent::action_sections('Борьба', 'site.sections.wrestling', 2);
	}
	
	public function legkaya_atletika(){
    	
    	return parent::action_sections('Легкая атлетика', 'site.sections.legkaya-atletika', 3);
	}
	
	public function tyazhelaya_atletika(){
    	
    	return parent::action_sections('Тяжелая атлетика', 'site.sections.tyazhelaya-atletika', 4);
	}
	
	public function football(){
    	
    	return parent::action_sections('Футбол', 'site.sections.football', 5);
	}
	
	public function volleyball(){
    	
    	return parent::action_sections('Волейбол', 'site.sections.volleyball', 6);
	}
	
	
	
}
