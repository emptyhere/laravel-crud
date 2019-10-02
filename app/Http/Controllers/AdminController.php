<?php

namespace App\Http\Controllers;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Mail;
use View;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
        protected $redirectTo = '/home';
    
        public function __construct()
        {
            $this->middleware('auth');
        }
    
    
        public function indexAll(Request $request) {
            $request->user()->authorizeRoles('admin');
            
            if ($request->get('search') !== null){        
                $usersId = DB::table('role_user')->where('role_id', '2')->pluck('user_id');
                $users = User::whereIn('id', $usersId);
                $search = $request->get('search');
                $posts = $users->where('name', $search)->paginate(5);
                return View::make('indexAdmin', compact('posts', 'search'));
            }
    
            $usersId = DB::table('role_user')->where('role_id', '2')->pluck('user_id');
            $users = User::whereIn('id', $usersId)->paginate(10);
            $posts = $users;
            return View::make('indexAdmin', compact('posts'));
        }
    
        public function index(Request $request) {
            $request->user()->authorizeRoles('admin');
            return view('createSuperUser');
    
        }
    
        protected function validator(array $data)
        {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }
    
        public function store(Request $request) {
            $request->user()->authorizeRoles(['admin']);
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            $user->roles()
                 ->attach(Role::where('name', 'admin')->first());
    
                $data = array('name' => $request['name'], 
                'password' => $request['password'],
                'email' => $request['email']);
    
            Mail::send([], $data, function($message) use ($data){
                $message->to($data['email'], $data['name'])->subject('Registration')
                ->setBody("Hi ".$data["name"].", Your's login is: ".$data['email'].", Your's password is: ".$data['password']);
            });    
            return redirect('admin/superuser');
        }
    
        public function show(Request $request, $id)
        {
            $request->user()->authorizeRoles('admin');
            $post = User::findOrFail($id);
            return view('showSuperUser')->withPost($post);
        }
    
        public function edit(Request $request, $id) {
            $request->user()->authorizeRoles('admin');
            $post = User::find($id);
            return View::make('updateSuperUser', compact('post'));
        }
    
        public function update(Request $request, $id)
        {
            $request->user()->authorizeRoles('admin');
            $post = User::find($id);  
            $post->fill($request->all());
            $post->save();
            $user = User::find($id);
            $data = array('name' => $user->name, 'email' => $user->email);
    
            Mail::send([], $data, function($message) use ($data){
                $message->to($data['email'], $data['name'])->subject('Update profile')
                ->setBody("Your's name is updated to: ".$data['name'].", Your's email is updated to: ".$data['email']);
            });
            return redirect('admin/superuser/'.$id.'/edit');
        }
    
        public function destroy(Request $request, $id) {
            $request->user()->authorizeRoles('admin');
            $post = User::find($id);
            $post->roles()->detach(Role::where('name', 'admin')->first());
            $post->delete();
            return redirect('admin/user/all');
        }
        
        public function sendEmail($id) {
                $user = User::find($id);
                $data = array('name' => $user->name, 'email' => $user->email);
    
                Mail::send([], $data, function($message) use ($data){
                    $message->to($data['email'], $data['name'])->subject('Test Subject')->setBody('Hi, welcome '.$data['name'].'!');
                });
                
                return redirect('admin/user/all');
        }
}
