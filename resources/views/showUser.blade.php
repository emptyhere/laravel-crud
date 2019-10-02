@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User') }}</div>
                
                    <div class="form-group row">
                            <div class="col-md-12 ml-3">
                             <h1>{{ $post->name }}</h1>
                                <div> 
                                    <h4>{{ $post->email }}</h4>
                                    <small> Created at {{$post->created_at}} </small>
                                    <div class="mt-2">
                                    <form action="{{ route('admin.user.delete', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('allUsers') }}" class="btn btn-dark">Back to all users</a>
                                        <a href="{{ route('admin.user.edit', $post->id) }}" class="btn btn-primary ml-2">Edit user</a>
                                        <button type="submit" class="btn btn-danger ml-2">
                                            {{ __('Delete this user') }}
                                        </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
