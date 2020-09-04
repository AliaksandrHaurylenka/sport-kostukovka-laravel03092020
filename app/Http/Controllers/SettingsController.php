<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Input;
use Response;

class SettingsController extends Controller
{
    /**
     * show a view with form to create settings
     */
    public function add() {
        return View::make( 'settings/new' );
    }
 
    /**
     * handle data posted by ajax request
     */
    public function create() {
        //check if its our form
        if ( Session::token() !== Input::get( '_token' ) ) {
            return Response::json( array(
                'msg' => 'Unauthorized attempt to create setting'
            ) );
        }
 
        $setting_name = Input::get( 'setting_name' );
        $setting_value = Input::get( 'setting_value' );
 
        //.....
        //validate data
        //and then store it in DB
        //.....
 
        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
        );
 
        return Response::json( $response );
    }
 
//end of class
}
