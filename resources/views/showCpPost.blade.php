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
                                    <div class="mt-2">
                                        @if($isLiked)
                                        <div style="display: flex; flex-direction: column;" class="mb-2">
                                            <img style="width:50%; " src="{{ Storage::url('public/'.$post->image) }}" class="img-thumbnail mb-2"/>
                                            <small> Created at {{$post->created_at}} </small>
                                            <br/><small> Category: {{$post->category}} </small>
                                        </div>
                                    <form action="{{ route('cp.post.delete', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="mt-2 btn btn-danger"><i class="fas fa-heart-broken"></i> {{ $likes }}</button>
                                    </form>

                                        @else
                                        <div style="display: flex; flex-direction: column;" class="mb-2">
                                        @if($post->image !== null)
                                            <img style="width:50%; " src="{{ Storage::url('public/'.$post->image) }}" class="img-thumbnail mb-2"/>
                                        @else
                                        @endif    
                                            <small> Created at {{$post->created_at}} </small>
                                            <br/><small> Category: {{$post->category}} </small>
                                        </div>
                                    <form action="{{ route('cpLike', $post->id) }}" method="PUT">
                                        @csrf
                                        <button type="submit" class="mt-2 btn btn-danger"><i class="fas fa-heart"></i> {{ $likes }}</button>
                                    </form>

                                        @endif
                                        <a href="{{ route('allCpPosts') }}" class="btn btn-dark mt-2">Back to all posts</a>
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
