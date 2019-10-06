@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Posts') }}</div>

                <div class="card-body">
                    <form method="GET" action="{{ route('allCpPosts') }}">
                        @csrf
                            <div class="form-group">

                                    <select class="form-control form-control-sm mt-2" id="search" name="search">
                                        @foreach ($getCategories as $cat)
                                            <option value="{{ $cat }}">{{ $cat }}</option>
                                        @endforeach
                                    </select>

                                    <span class="form-group-btn">
                                        <button type="submit" class="btn btn-primary mt-2" id="btn-search-select">Search</button>
                                        <a href="{{ route('allCpPosts') }}" class="btn btn-dark mt-2">Back to all posts</a>
                                    </span>

                            </div>
                            @if (count($posts) < 1 && empty($search) === !1)
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <center>
                                        <h1>Post "<span style="color:grey">{{ $search ?? ''}}</span>" not found.</h1>
                                    </center>
                                </div>      
                            </div>  
                            @endif
                            @if (empty($search) && count($posts) < 1)
                            <div class="form-group row">
                                <div class="col-md-12">
                                        <center>
                                            <h1>No posts.</h1>
                                        </center>
                                    </div>      
                                </div>  
                            @endif

                        @foreach ($posts as $post)
                        <div class="form-group row">
                            <div class="col-md-12">
                             <h1>{{ $post->title }}</h1>
                                <div> 
                                    <h4>{{ $post->description }}</h4>
                                        <div style="display: flex; flex-direction: column;" class="mb-2">
                                        @if($post->image !== null)
                                            <img style="width:25%; " src="{{ Storage::url('public/'.$post->image) }}" class="img-thumbnail mb-2"/>
                                        @else
                                        @endif    
                                            <small> Created at {{$post->created_at}} </small>
                                            <br/><small> Category: {{$post->category}} </small>
                                        </div>
                                    <a href="{{ route('cp.post.show', $post->id) }}" class="btn btn-success ml-2">View post</a>
                                        </form>
                                    </div>
                                <hr/>
                            </div>
                        </div>
                        @endforeach

                        @if (count($posts) < 1)
                        <div class="form-group row">
                        <div class="col-md-12">
                                <center>
                                    <h1>No posts.</h1>
                                </center>
                            </div>      
                        </div>
                        @endif

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
