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
                                        @if($isLiked)

                                    <form action="{{ route('cp.post.delete', $post->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="mt-2 btn btn-danger"><i class="fas fa-heart-broken"></i> {{ $likes }}</button>
                                    </form>

                                        @else

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
