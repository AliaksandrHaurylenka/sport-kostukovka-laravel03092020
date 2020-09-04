<?php

namespace App\Http\Controllers;

use App\Mail\SubscribesEmail;
use App\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscribesController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function subscribe(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'email' => 'required|email|unique:subscribes'
        ]);

        $subs = Subscribe::add($request->get('email'));
        $subs->generateToken();
//        dd($subs);

        Mail::to($subs)->send(new SubscribesEmail($subs));

        return redirect()->back()->with('status', 'Проверьте пожалуйста свою почту!');
    }


    public function verify($token)
    {
//        dd($token);
        $subs = Subscribe::where('token', $token)->firstOrFail();
        $subs->token = null;
        $subs->save();
        return redirect(route('main'))->with('status', 'Ваша почта подтверждена! СПАСИБО!');
    }
}
