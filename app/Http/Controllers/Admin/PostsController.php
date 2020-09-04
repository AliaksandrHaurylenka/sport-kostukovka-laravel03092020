<?php

namespace App\Http\Controllers\Admin;

use App\FoldersSystem;
use App\Post;
use App\Section;
use App\Subscribe;
use App\Tag;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostsRequest;
use App\Http\Requests\Admin\UpdatePostsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Controllers\Traits\FileUploadPostTrait;
use Illuminate\Support\Facades\Notification;


class PostsController extends Controller
{
//    use FileUploadTrait;
    use FileUploadPostTrait;
    use Notifiable;
    /**
     * Display a listing of Post.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('post_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('post_delete')) {
                return abort(401);
            }
            $posts = Post::onlyTrashed()->get();
        } else {
//            Вывод постов для админа и простого пользователя
            if(Auth::user()->role_id == 2){
                $posts = Post::where('user_id', Auth::user()->id)->latest()->get();
            }
            else {
                $posts = Post::all()->reverse();
            }
        }

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating new Post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('post_create')) {
            return abort(401);
        }
        $tags = Tag::pluck('title', 'id')->all();
        $sections = Section::pluck('title', 'id');

        if (Auth::user()->role_id == 2){
            FoldersSystem::add_folder_for_img(User::NEWS_PATH.Auth::user()->name.'/N_', Post::max('id')+1);
        }
        else{
            FoldersSystem::add_folder_for_img(Post::NEWS . 'N_', Post::max('id')+1);
        }



        return view('admin.posts.create', compact( 'tags', 'sections'));
    }

    /**
     * Store a newly created Post in storage.
     *
     * @param StorePostsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostsRequest $request)
    {
        if (! Gate::allows('post_create')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Post::PATH, 800, 450);
        // функция add() используется для добавления id пользователя
        // и всех остальных данных
        // находится в Post.php
        $post = Post::add($request->all());
        $post->setTags($request->get('tags'));
        $post->toggleStatus($request->get('status'));
        $post->toggleFeatured($request->get('is_featured'));


        User::mailNotification($post);
        Subscribe::mailNotification($post);


        return redirect()->route('admin.posts.index');
    }


    /**
     * Show the form for editing Post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('post_edit')) {
            return abort(401);
        }

        if (Auth::user()->role_id == 2){
            FoldersSystem::add_folder_for_img_edit($id, User::NEWS_PATH.Auth::user()->name.'/', Post::where('id', $id));
        }
        else{
            FoldersSystem::add_folder_for_img_edit($id, Post::NEWS, Post::where('id', $id));
        }


        $post = Post::findOrFail($id);
        $sections = Section::pluck('title', 'id');
        $tags = Tag::pluck('title', 'id')->all();
        $selectedTags = $post->tags->pluck('id')->all();

        return view('admin.posts.edit', compact('post', 'sections', 'tags', 'selectedTags'));
    }

    /**
     * Update Post in storage.
     *
     * @param UpdatePostsRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostsRequest $request, $id)
    {
        if (! Gate::allows('post_edit')) {
            return abort(401);
        }
        $request = $this->saveFiles($request, Post::PATH, 800, 450);
        $post = Post::findOrFail($id);
        $post->slug = null;
        $post->status = Post::IS_DRAFT;
        $post->setTags($request->get('tags'));
        if($request->input('tags') == null){
            $post->delTags($id);
        }
        if($_FILES['image']['name']){
            $post->removeImg();
        }
        $post->toggleStatus($request->get('status'));
        $post->toggleFeatured($request->get('is_featured'));
        $post->edit($request->all());

        User::mailNotification($post);
        Subscribe::mailNotification($post);



        return redirect()->route('admin.posts.index');
    }


    /**
     * Remove Post from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('post_delete')) {
            return abort(401);
        }
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts.index');
    }

    /**
     * Delete all selected Post at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('post_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Post::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Post from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('post_delete')) {
            return abort(401);
        }
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('admin.posts.index');
    }

    /**
     * Permanently delete Post from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('post_delete')) {
            return abort(401);
        }

        if (Auth::user()->role_id == 2){
            FoldersSystem::del_folder_img($id, 'posts', User::NEWS_PATH.Auth::user()->name.'/');
        }
        else{
            FoldersSystem::del_folder_img($id, 'posts', Post::NEWS);
        }



        $post = Post::onlyTrashed()->findOrFail($id);
        $post->delTags($id);
        $post->remove();

        return redirect()->route('admin.posts.index');
    }

    /**
     * Запретить, опубликовать пост в админке posts->index.blade.php
     * Используется в роутере Route::get('/post/toggle/{id}', 'Admin\PostsController@toggle')
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle($id)
    {
        $post = Post::find($id);
        $post->statusToggle();

        User::mailNotification($post);
        Subscribe::mailNotification($post);


        return redirect()->back();
    }
}
