<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use App\Post;
use Illuminate\Support\Facades\Mail;
use View;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class CpController extends Controller
{
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function indexAll(Request $request) {
        $request->user()->authorizeRoles('user');
        
        if ($request->get('search') !== null){        
            $search = $request->get('search');
            $posts = DB::table('posts')->where('title', $search)->paginate(5);
            return View::make('indexCpPost', compact('posts', 'search'));
        }

        $posts = Post::paginate(5);
        return View::make('indexCpPost', compact('posts'));
    }

    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles('user');
        $post = Post::findOrFail($id);
        $user = Auth::id();
        $likes = DB::table('post_user')->where('post_id', $post->id)->get()->count();
        $isLiked = DB::table('post_user')->where('post_id', $post->id)->where('user_id', $user)->get()->count();
        View::share('likes', $likes);
        View::share('isLiked', $isLiked);
        return view('showCpPost')->withPost($post);
    }


    public function like(Request $request, $id)
    {
        $request->user()->authorizeRoles('user');
        $post = Post::find($id);
        $userId = Auth::id();
        $post->users()->attach(User::where('id', $userId)->first());
        return back();
    }


    public function destroy(Request $request, $id) {
        $request->user()->authorizeRoles('user');
        $post = Post::find($id);
        $user = Auth::id();
        $like = DB::table('post_user')->where('post_id', $post->id)->where('user_id', $user);
        $like->delete();
        return back();
    }
}
