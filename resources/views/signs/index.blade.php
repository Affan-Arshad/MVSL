@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="m-0">{{ $title }}</h4>
                </div>

                <div class="card-body">
                    @if ($signs->count())
                    @foreach($signs as $sign)
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
                    @else
                    We couldn't find anything
                    @endif
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