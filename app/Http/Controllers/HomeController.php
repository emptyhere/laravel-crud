<?php

namespace App\Http\Controllers;
use DB;
use View;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Post;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $getPostsId = DB::table('posts')->pluck('id');

        $howUsers = DB::table('role_user')->where('role_id', 1)->get()->count();
        $howAdmins = DB::table('role_user')->where('role_id', 2)->get()->count();
        $howPosts = DB::table('posts')->get()->count();
        $howLikes = DB::table('post_user')->get()->count();
        $howShowed = DB::table('show_post_user')->select('post_id','user_id')->distinct()->get()->count();

        //$lastWeek = Carbon::now()->subDays(7)->format('Y-m-d');
        //$postStat = DB::table('posts')->where('created_at', '>=', $lastWeek)->get();
       
        function statPostAndLike($tab) {
            $dates = collect();

            foreach( range( -6, 0 ) AS $i ) {
                $date = Carbon::now()->addDays( $i )->format( 'Y-m-d' );
                $dates->put( $date, 0);
            }
            
            $posts = DB::table($tab)->where( 'created_at', '>=', $dates->keys()->first() )
                        ->groupBy( 'date' )
                        ->orderBy( 'date' )
                        ->get( [
                            DB::raw( 'DATE( created_at ) as date' ),
                            DB::raw( 'COUNT( * ) as "count"' )
                        ] )
                        ->pluck( 'count', 'date' );
            
            $dates = $dates->merge( $posts );
            return $dates;
        }

             
        function statShowed($tab) {
            $dates = collect();

            foreach( range( -6, 0 ) AS $i ) {
                $date = Carbon::now()->addDays( $i )->format( 'Y-m-d' );
                $dates->put( $date, 0);
            }

            $posts = DB::table($tab)->where( 'created_at', '>=', $dates->keys()->first() )
                        ->groupBy( 'date' )
                        ->orderBy( 'date' )
                        ->get( [
                            DB::raw( 'DATE( created_at ) as date' ),
                            DB::raw( 'COUNT( * ) as "count"' )
                        ] )
                        ->pluck( 'count', 'date' );
            
            $dates = $dates->merge( $posts);
            return $dates;
        }
        
        $statShow = statShowed('show_post_user');
        $statLike = statPostAndLike('post_user');
        $statPost = statPostAndLike('posts');

       // return response()->json(statShowed('show_post_user'));
        return View::make('home', compact('howUsers', 'howAdmins', 
            'howPosts', 'howLikes', 
            'howShowed', 'statShow', 
            'statLike', 'statPost',
        ));
    }
}
