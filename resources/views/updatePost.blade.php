@extends('layouts.app')

@section('content') 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update post') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.post.update', $post->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>
                            <div class="col-md-6">
                                <input type="hidden" name="_method" value="PUT">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $post->title }}" required autocomplete="title" autofocus>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>  
                            <div class="col-md-6">
                                <input id="description" type="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $post->description }}"
                                 required autocomplete="description">
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>  
                            <div class="col-md-6">
                                <input id="category" type="category" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ $post->category }}"
                                 required autocomplete="category">
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image_s" class="col-md-4 col-form-label text-md-right">Image's </label>  
                            <div class="col-md-6">
                                <input id="image_s" type="text" class="form-control @error('image_s') is-invalid @enderror" value="{{ $post->image }}"
                                 required autocomplete="image_s" readonly>
                    

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div style="max-width: 100%; display: flex;">
                            @if($post->image !== null)
                                <img style="width:50%;margin-left: auto; margin-right: auto;" src="{{ Storage::url('public/'.$post->image) }}" class="img-thumbnail mt-4" />
                            @else
                            @endif    
                        </div>

                        <div class="form-group row mt-4">
                            <div class="form-group" class="col-md-6" style="margin-left: auto; margin-right: auto;">
                                <label for="image">{{ __('Image') }}</label>
                                <input type="file" class="form-control-file" id="image" name="image" >
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edit post') }}
                                </button>
                                <a href="{{ route('allPosts') }}" class="btn btn-dark">Back to all posts</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
