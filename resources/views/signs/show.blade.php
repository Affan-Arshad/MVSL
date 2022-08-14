@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="m-0">
                        @foreach ($sign->tagsWithType('meaning') as $tag)
                        {{ $tag->name }} {{ (!$loop->last ? ' / ' : '') }}
                        @endforeach
                    </h4>
                </div>

                <div class="card-body">

                    <video width=100% controls>
                        <source src="{{ \Storage::url($sign->video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                    <p class="mt-2 font-weight-bold">{{ $sign->explanation }}</p>

                    @if ($sign->tagsWithType('category')->count())
                    <h5 class="d-inline">Categories: </h5>
                    @foreach ($sign->tagsWithType('category') as $tag)
                    <a href="{{ route('signs.index', ['cat' => $tag->name]) }}">{{ $tag->name }}</a>
                    {{ (!$loop->last ? ' / ' : '') }}
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4 mt-md-0">
            <div class="card">
                <div class="card-header">Related</div>

                <div class="card-body">
                    @if ($related->count())

                    @else
                    We couldn't find anything
                    @endif
                    @foreach($related as $sign)
                    <a href="{{ route('signs.show', $sign->id) }}">
                        <p class="m-0">
                            @foreach ($sign->tagsWithType('meaning') as $tag)
                            {{ $tag->name }} {{ (!$loop->last ? ' / ' : '') }}
                            @endforeach
                        </p>
                    </a>
                    @if (!$loop->last)
                    <hr>
                    @endif
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