@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Signs</h4>
                    <a class="btn btn-success text-white" href="{{ route('admin.signs.create') }}">+ Add Sign</a>
                </div>

                <div class="card-body">
                    <table class="table m-0 border">
                        <thead>
                            <tr>
                                <th>Meanings</th>
                                <th>Video</th>
                                <th>Categories</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($signs as $sign)
                            <tr>
                                <td>
                                    <a target="_blank" href="{{ route('signs.show', $sign->id) }}">
                                        @foreach ($sign->tagsWithType('meaning') as $meaning)
                                        {{ $meaning->name }} {{ (!$loop->last ? ' / ' : '') }}
                                        @endforeach
                                    </a>
                                </td>
                                <td>
                                    {{ $sign->video ? 'Yes' : 'No' }}
                                </td>
                                <td>
                                    @foreach ($sign->tagsWithType('category') as $category)
                                    {{ $category->name }} {{ (!$loop->last ? ' | ' : '') }}
                                    @endforeach
                                </td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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