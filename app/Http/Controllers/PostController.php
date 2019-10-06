<?php

namespace App\Http\Controllers;
use App\Post;
use App\User;
use View;
use Image;
use Storage;
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
            $posts = DB::table('posts')->where('title', $search)->orWhere('description', $search)
            ->orWhere('category', $search)->paginate(5);
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

        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->category = $request->category;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $img = Image::make($image)->encode('jpg', 75);
            Storage::put($filename, $img);
            Storage::move($filename, 'public/' . $filename);
            $post->image = $filename;
            $post->save();
            return redirect('admin/post');
        } 

        $post->save();
        
        //$post = Post::create($request->all());
        //return response()->json($post);
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

        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post->title = $request->title;
        $post->description = $request->description;
        $post->category = $request->category;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $img = Image::make($image)->encode('jpg', 75);
            Storage::put($filename, $img);
            Storage::move($filename, 'public/' . $filename);
            $post->image = $filename;
            $post->update();

            return redirect('admin/post/'.$id.'/edit');
        } 

        $post->update();
        return redirect('admin/post/'.$id.'/edit');
    }

    public function destroy(Request $request, $id) {
        $request->user()->authorizeRoles('admin');
        $post = Post::find($id);  
        $post->delete();
        return redirect('admin/post/all');
    }
    
}
