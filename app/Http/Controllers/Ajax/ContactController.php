<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\LetterMail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        //dd($request->all());

        $result = false;
         
        if($request->ajax() && !empty($request->all()))
        {
            /*$sender = $request;
             
            Mail::send('emails.feedback', ['sender' => $sender], function($message) use ($sender) {
                $message->from($sender->email, $sender->name);
                $message->to(env('MAIL_ADMIN'));
                //$message->subject($sender->subject);
            });*/


            $messages = [
                'required' => 'Поле :attribute обязательно к заполнению',
                'email' => 'Поле :attribute должно быть email адресом',
            ];

            $this->validate($request, [
                'email' => 'required|email',
                'name' => 'required|max:255',
                'text' => 'required|max:1000',
            ], $messages);

            $data = $request->all();

             Mail::send(new LetterMail($data));
             
            $result = true;
        }
         
        return response()->json(['result' => $result]);
    }
}
