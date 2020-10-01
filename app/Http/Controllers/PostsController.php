<?php

  namespace App\Http\Controllers;

  use App\Category;
  use App\Section;
  use App\Notifications\NewEvent;
  use App\Post;
  use App\Tag;
  use App\User;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\DB;


  class PostsController extends Controller
  {
    public function index()
    {

      $posts = Post::where('status', Post::IS_PUBLIC)
        ->latest('date')
        ->latest('id')
        ->paginate(3)
        ->onEachSide(2);


      return view('site.posts', compact('posts'));
    }

    /**
     * Вывод одного поста
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post($slug)
    {
      //dd(get_class_methods('Auth'));
//        dd($slug);
      $post = Post::where('status', Post::IS_PUBLIC)->where('slug', $slug)->firstOrFail();
      event('postHasViewed', $post);//для подсчета количества просмотров постов. Провайдер EventServiceProvider.php
//         dd($post->comments);
//        dd($post->id);
      return view('site.post', compact('post'));
    }


    /**
     * Вывод всех статей категории
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($slug)
    {
      $category = Section::where('slug', $slug)->firstOrFail();
      $section = DB::table('sections')->where('slug', $slug)->first();


      $posts = $category->posts()
        ->where('status', 1)
        ->orderByRaw('date desc, id desc')
        ->paginate(6);

      return view('site.posts-list', compact('posts', 'section'));
    }


    /**
     * Вывод всех статей без категории
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function no_category()
    {
      $posts = Post::where('section_id', 0)
        ->where('status', 1)
        ->orderByRaw('date desc, id desc')
        ->paginate(6);
      //dd($posts);

      $section = false;
      $tag_title = false;
      $year = false;
      $user_name = false;

      return view('site.posts-list', compact('posts', 'section', 'tag_title', 'year', 'user_name'));
    }


    /**
     * Вывод меток
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag($slug)
    {
      $tag = Tag::where('slug', $slug)->firstOrFail();
      $tag_title = DB::table('tags')->where('slug', $slug)->first();
//        dd($t);
      $section = false;
      $year = false;
      $user_name = false;

      $posts = $tag->posts()
        ->where('status', 1)
        ->orderByRaw('date desc, id desc')
        ->paginate(6);

      return view('site.posts-list', compact('posts', 'tag_title', 'section', 'year', 'user_name'));
    }


    /**
     * Вывод пользователя добавившего пост
     * @param $id
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user_posts($id, $name)
    {
      $user = User::where('id', $id)->where('name', $name)->firstOrFail();
//        dd($user);
      $user_name = DB::table('users')->where('name', $name)->first();
//        dd($u);
      $section = false;
      $tag_title = false;
      $year = false;
      $posts = $user->posts()
        ->where('status', 1)
        ->orderByRaw('date desc, id desc')
        ->paginate(6);

      return view('site.posts-list', compact('posts', 'section', 'tag_title', 'user_name', 'year'));
    }

    /**
     * Вывод архива новостей
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archive($year)
    {
      $archive = Post::whereYear('date', $year);
      //dd($archive);
      $year = $year;
      $section = false;
      $tag_title = false;
      $user_name = false;


      $posts = $archive
        ->where('status', 1)
        ->latest('date')
        ->paginate(6);

      return view('site.posts-list', compact('posts', 'section', 'tag_title', 'user_name', 'year'));
    }

      /**
       * Вывод архива новостей
       * @param $month
       * @param $year
       * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
       */
    public function archiveMonthYear($month, $year)
    {
      $archive = Post::whereMonth('date', $month)->whereYear('date', $year)->get();
      //$month = Post::whereMonth('date', $month);
      //$year = Post::whereYear('date', $year);
      dd($archive);
      $y = $year;
      //$y = $month.$year;
      $cat = false;
      $t = false;
      $u = false;


      $posts = $archive
        ->where('status', 1)
        ->latest('date')
        ->paginate(6);

      return view('site.posts-list', compact('posts', 'cat', 't', 'u', 'y'));
    }
  }
