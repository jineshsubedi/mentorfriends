@extends('layouts.app')

@include('layouts.nav')
@section('content')
    <div class="container">
        <section id="blog-list">
            <div class="row">
                @forelse ($blogs as $k=>$blog)
                <div class="col-md-3">
                    <div class="card">
                        <img src="{{$blog->image_path}}" class="card-img-top" width="80%">
                        <div class="card-body">
                            <h5 class="card-title">{{$blog->title}}</h5>
                            <p class="card-text">{{$blog->description}}</p>
                            <a href="{{route('blog.show', $blog->slug)}}" class="btn btn-primary">click here</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="alert alert-info">No Blog Found!</div>
                @endforelse

            </div>
        </section>
    </div>
@endsection
    