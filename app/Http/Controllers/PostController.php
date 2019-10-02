<?php

namespace App\Http\Controllers;
use App\Post;
use View;
use Illuminate\Http\Request;
use DB;

class PostController extends Controller
{

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function indexAll(Request $request) {
        $request->user()->authorizeRoles('admin');
        
        if ($request->get('search') !== null){        
            $search = $request->get('search');
            $posts = DB::table('posts')->where('title', $search)->paginate(5);
            return View::make('indexPost', compact('posts', 'search'));
        }

        $posts = Post::paginate(5);
        return View::make('indexPost', compact('posts'));
    }

    public function index(Request $request) {
        $request->user()->authorizeRoles('admin');
        return view('createPost');

    }

    public function store(Request $request) {
        $request->user()->authorizeRoles(['admin']);
        $post = Post::create($request->all());
        return redirect('admin/post');
    }

    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles('admin');
        $post = Post::findOrFail($id);
        return view('showPost')->withPost($post);
    }

    public function edit(Request $request, $id) {
        $request->user()->authorizeRoles('admin');
        $post = Post::find($id);
        return View::make('updatePost', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles('admin');
        $post = Post::find($id);  
        $post->fill($request->all());
        $post->save();
        return redirect('admin/post/'.$id.'/edit');
    }

    public function destroy(Request $request, $id) {
        $request->user()->authorizeRoles('admin');
        $post = Post::find($id);  
        $post->delete();
        return redirect('admin/post/all');
    }
    
}
