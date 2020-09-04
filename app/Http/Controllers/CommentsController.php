<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Post;
use Illuminate\Http\Request;
use Auth;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->get('post_id'));
        if(Auth::check()){
            $this->validate($request, [
                'message' => 'required',
            ]);
        }else{
            $this->validate($request, [
                'message' => 'required',
                'name' => 'required',
            ]);
        }

        $comment = new Comment();
        $post = new Post();
        $comment->text = $request->get('message');
        $comment->post_id = $request->get('post_id');

        $comment->disAllow();
        

        // dd(Auth::check());
        //$comment->user_id = Auth::check();
        //$comment->user_id = Auth::user()->id;
        if(Auth::check()){
            $comment->user_id = Auth::user()->id;
        }else{
            $comment->name = $request->get('name');
        }

        // dd($comment);
        // dd(env('APP_URL_SITE').'/post/'. $comment->post->slug);
        Comment::mailNotification($comment);

        // dd($comment->user_id);
        $comment->save();

        return redirect()->back()->with('status', 'Спасибо. Ваш комментарий скоро будет опубликован.');
    }
}
