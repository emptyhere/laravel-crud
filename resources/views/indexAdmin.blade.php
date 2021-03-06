@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admins') }}</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('allAdmins') }}">
                        @csrf
                            <div class="form-group">
                                <input type="search" class="form-control" name="search">
                                <span class="form-group-btn">
                                    <button type="submit" class="btn btn-primary mt-2">Search</button>
                                    <a href="{{ route('allAdmins') }}" class="btn btn-dark mt-2">Back to all admins</a>
                                </span>
                            </div>
                            @if (count($posts) < 1 && empty($search) === !1)
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <center>
                                        <h1>Admin "<span style="color:grey">{{ $search ?? ''}}</span>" not found.</h1>
                                    </center>
                                </div>      
                            </div>  
                            @endif
                            @if (empty($search) && count($posts) < 1)
                            <div class="form-group row">
                                <div class="col-md-12">
                                        <center>
                                            <h1>No users.</h1>
                                        </center>
                                    </div>      
                                </div>  
                            @endif
                        @foreach ($posts as $post)
                        <div class="form-group row">
                            <div class="col-md-12">
                             <h1>{{ $post->name }}</h1>
                                <div> 
                                    <h4>{{ $post->email }}</h4>
                                    <small> Created at {{$post->created_at}} </small>
                                    <form action="{{ route('admin.user.delete', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    <a href="{{ route('admin.superuser.show', $post->id) }}" class="btn btn-success ml-2">View admin</a>
                                    <a href="{{ route('admin.superuser.edit', $post->id) }}" class="btn btn-primary ml-2">Edit</a>
                                        <button type="submit" class="btn btn-danger ml-2" value="delete">
                                            {{ __('Delete') }}
                                        </button>
                                        </form>
                                    </div>
                                <hr/>
                            </div>
                        </div>
                        @endforeach

                    </form>
                    <div class="container">
                        <div class="row">
                            <div class="pagination">
                                <span class="pagination__list">{{$posts->links('paginate')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
