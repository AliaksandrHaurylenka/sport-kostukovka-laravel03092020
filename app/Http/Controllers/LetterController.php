<?php

  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Mail;
//use League\Flysystem\Config;
  use App\Mail\LetterMail;
  use App\Mail\Feedback;

  class LetterController extends Controller
  {
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function letter(Request $request)
    {
      //dd($request->all());

      if ($request->isMethod('post')) {
        //if($request->isAjax()){

        $messages = [
          'required' => 'Поле :attribute обязательно к заполнению',
          'email' => 'Поле :attribute должно быть email адресом',
          'captcha' => 'Код с картинки введен неверно',
        ];

        $this->validate($request, [
          'email' => 'required|email',
          'name' => 'required|max:255',
          'text' => 'required|max:1000',
          'captcha' => 'required|captcha',
        ], $messages);

        $data = $request->all();

        Mail::send(new LetterMail($data));

        // return redirect()->back()->with('status', 'Ваше сообщение отправлено!');
        flash('Ваше сообщение отправлено!')->success()->important();
        // flash()->overlay('Ваше сообщение отправлено!', 'Уведомление');
        return redirect()->back();       
      }
    }
  }
