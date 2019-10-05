@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                @if (Auth::user()->hasRole('admin'))

                <div>Count of users is {{ $howUsers }}.</div>
                <div>Count of admins is {{ $howAdmins }}.</div>
                <div>Count of posts is {{ $howPosts }}.</div>
                <div>Count of likes is {{ $howLikes }}.</div>
                <div>Count of showed posts is {{ $howShowed }}.</div>
                    <hr/>
                    
                <div class="mt-3">
                    <h3>Posts stats.</h3>
                @foreach ( $statPost as $date => $count ) 
                    <div> Created {{ $count }} posts at {{ $date }}.</div>
                @endforeach
                </div>
                     <hr/>
                    
                <div class="mt-3">
                    <h3>Likes stats.</h3>
                @foreach ( $statLike as $date => $count ) 
                    <div> Liked {{ $count }} posts at {{ $date }}.</div>
                @endforeach
                </div>
                <hr/>
                    
                <div class="mt-3">
                    <h3>Shows stats.</h3>
                @foreach ( $statShow as $date => $count ) 
                    <div> Showed {{ $count }} posts at {{ $date }}.</div>
                @endforeach
                </div>
                    
                @elseif (Auth::user()->hasRole('user'))
                    <p>You successful logined!</p>
                @endif

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
