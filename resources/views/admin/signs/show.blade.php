@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>
                        @foreach ($sign->tagsWithType('meaning') as $meaning)
                        {{ $meaning->name }} {{ (!$loop->last ? ' / ' : '') }}
                        @endforeach
                    </h4>
                </div>

                <div class="card-body">

                    <video width=100% controls>
                        <source src="{{ \Storage::url($sign->video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                    <p>{{ $sign->explanation }}</p>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Categories</div>

                <div class="card-body">
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