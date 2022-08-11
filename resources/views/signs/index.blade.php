@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Signs</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <ul>
                        @foreach($tags as $tag)
                        <li>{{ $tag->name }}</li>
                        {{-- <video width="320" height="240" controls>
                        <source src="{{ \Storage::url($sign->video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                        </video> --}}
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Categories</div>

                <div class="card-body">
                    @foreach($tagCats as $cat)
                    <a href="/signs?cat={{ $cat }}">{{ $cat }}</a><br>
                    {{-- <video width="320" height="240" controls>
                        <source src="{{ \Storage::url($sign->video) }}" type="video/mp4">
                    Your browser does not support the video tag.
                    </video> --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_css')
@endsection
@section('additional_js')
@endsection