@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Post') }}</div>
                
                    <div class="form-group row">
                            <div class="col-md-12 ml-3">
                             <h1>{{ $post->title }}</h1>
                                <div> 
                                    <h4>{{ $post->description }}</h4>
                                    <small> Created at {{$post->created_at}} </small>
                                    <div class="mt-2">
                                    <div style="display: flex; flex-direction: column;" class="mb-2">
                                        @if($post->image !== null)
                                            <img style="width:50%; " src="{{ Storage::url('public/'.$post->image) }}" class="img-thumbnail mb-2"/>
                                        @else
                                        @endif    
                                            <small> Created at {{$post->created_at}} </small>
                                            <br/><small> Category: {{$post->category}} </small>
                                        </div>
                                    <form action="{{ route('admin.post.delete', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('allPosts') }}" class="btn btn-dark">Back to all posts</a>
                                        <a href="{{ route('admin.post.edit', $post->id) }}" class="btn btn-primary ml-2">Edit post</a>
                                        <button type="submit" class="btn btn-danger ml-2">
                                            {{ __('Delete this post') }}
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
