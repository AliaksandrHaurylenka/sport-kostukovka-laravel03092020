<?php

namespace App\Http\Controllers\Api\V1;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostsRequest;
use App\Http\Requests\Admin\UpdatePostsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;

class PostsController extends Controller
{
    use FileUploadTrait;

    public function index()
    {
        return Post::all();
    }

    public function show($id)
    {
        return Post::findOrFail($id);
    }

    public function update(UpdatePostsRequest $request, $id)
    {
        $request = $this->saveFiles($request);
        $post = Post::findOrFail($id);
        $post->update($request->all());
        

        return $post;
    }

    public function store(StorePostsRequest $request)
    {
        $request = $this->saveFiles($request);
        $post = Post::create($request->all());
        

        return $post;
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return '';
    }
}
