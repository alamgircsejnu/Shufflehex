<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Embed\Embed;
use App\Post;
use App\Image;
use App\User;
use App\Category;
use App\Folder;
use App\SavedStories;
use carbon;
use Auth;
use DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('votes')->with('comments')->with('saved_stories')->orderBy('views', 'DESC')->get();

        return view('pages/all', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user = User::find($request->user_id);
        $info = Embed::create($request->link);

        $explodedLink = explode('//', $request->link);
        if (isset($explodedLink[1]) && !empty($explodedLink[1])) {
            $domainName = explode('/', $explodedLink[1]);
        }else {
            $domainName = explode('/', $explodedLink[0]);
        }
        $posts = new Post();
        $posts->title = $request->title;
        $posts->link = $request->link;
        $posts->domain = $domainName[0];
        $posts->featured_image = $info->image;
        $posts->category = $request->category;
        $posts->description = $request->description;
        $posts->tags = $request->tags;
        $posts->user_id = $request->user_id;
        $posts->username = $user->username;
        $posts->views = 0;
        $posts->post_votes = 0;
        $posts->post_comments = 0;
        $posts->is_link = 1;
        $posts->is_image = 0;
        $posts->is_video = 0;
        $posts->is_article = 0;
        $posts->is_list = 0;
        $posts->is_poll = 0;
        $posts->save();

        return redirect('post');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('pages.OldPages.iframeView', compact('post'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showPost($id,$title)
    {
        $views = Post::find($id);
        $views->views += 1;
        $views->update();

        $post = Post::with('comments')->find($id);
        return view('pages.story', compact('post'));
    }

     public function latestPost()
    {
        $date = new Carbon\Carbon; //  DateTime string will be 2014-04-03 13:57:34

        $date->subWeek(); // or $date->subDays(7),  2014-03-27 13:58:25
        // dd($date);
        $posts = Post::with('votes')->with('comments')->where('created_at','>=',$date->toDateTimeString())->orderBy('created_at', 'DESC')->get();

        return view('pages/latest', compact('posts'));
    }

    public function topPost()
    {
        $date = new Carbon\Carbon; //  DateTime string will be 2014-04-03 13:57:34

        $date->subWeek(); // or $date->subDays(7),  2014-03-27 13:58:25
        // dd($date);
        $posts = Post::with('votes')->with('comments')->where('created_at','>=',$date->toDateTimeString())->orderBy('views', 'DESC')->get();

        return view('pages/top', compact('posts'));
    }

    public function popularPost()
    {
        $date = new Carbon\Carbon; //  DateTime string will be 2014-04-03 13:57:34

        $date->subWeek(); // or $date->subDays(7),  2014-03-27 13:58:25
        // dd($date);
        $posts = Post::with('votes')->with('comments')->where('created_at','>=',$date->toDateTimeString())->orderBy('post_votes', 'DESC')->get();

        return view('pages/popular', compact('posts'));
    }

    public function trendingPost()
    {
        $date = new Carbon\Carbon; //  DateTime string will be 2014-04-03 13:57:34

        $date->subWeek(); // or $date->subDays(7),  2014-03-27 13:58:25
        // dd($date);
        $posts = Post::with('votes')->with('comments')->where('created_at','>=',$date->toDateTimeString())->orderBy('post_votes', 'DESC')->orderBy('post_comments', 'DESC')->get();

        return view('pages/trending', compact('posts'));
    }

    public function webPost()
    {
        
        $posts = Post::with('votes')->with('comments')->where('is_link','=','1')->orderBy('created_at', 'DESC')->get();

        return view('pages/web', compact('posts'));
    }

    public function imagesPost()
    {
        
        $posts = Post::with('votes')->with('comments')->where('is_image','=','1')->orderBy('created_at', 'DESC')->get();

        return view('pages/images', compact('posts'));
    }


    public function videosPost()
    {
        
        $posts = Post::with('votes')->with('comments')->where('is_video','=','1')->orderBy('created_at', 'DESC')->get();

        return view('pages/videos', compact('posts'));
    }


    public function articlesPost()
    {
        
        $posts = Post::with('votes')->with('comments')->where('is_article','=','1')->orderBy('created_at', 'DESC')->get();

        return view('pages/articles', compact('posts'));
    }


    public function listsPost()
    {
        
        $posts = Post::with('votes')->with('comments')->where('is_list','=','1')->orderBy('created_at', 'DESC')->get();

        return view('pages/lists', compact('posts'));
    }


    public function pollsPost()
    {
        
        $posts = Post::with('votes')->with('comments')->where('is_poll','=','1')->orderBy('created_at', 'DESC')->get();

        return view('pages/polls', compact('posts'));
    }


    public function savedPost()
    {
        $userId = Auth::user()->id;
        $folders = Folder::where('user_id','=',$userId)->get();
//        dd($folders);
        $savedPosts = DB::table('posts')->join('saved_stories', 'posts.id', '=', 'saved_stories.post_id')->where('saved_stories.user_id','=',$userId)->get();
//        $savedPosts = SavedStories::with('posts')->where('user_id','=',$userId)->orderBy('created_at', 'DESC')->get();

        return view('pages/saved', compact('savedPosts','folders'));
    }



}