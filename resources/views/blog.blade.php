@extends('layouts.app')

@include('layouts.nav')
@section('content')
<div class="container">
    <div class="card text-center">
        <div class="card-header">
        {{ucwords($blog->title)}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{$blog->image_path}}" width="80%">
                </div>
                <div class="col-md-8">
                    <p class="">{{$blog->description}}</p>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            {{\Carbon\Carbon::parse($blog->created_at)->format('d F, Y')}}
        </div>
    </div>
</div>
@endsection