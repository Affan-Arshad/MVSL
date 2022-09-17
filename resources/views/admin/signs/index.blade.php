@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Signs</h4>

                    @can('create_signs')
                    <a class="btn btn-success text-white" href="{{ route('admin.signs.create') }}">+ Add Sign</a>
                    @endcan
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
                                    <a target="_blank" href="{{ route('signs.index', ['cat' => $category->name]) }}">{{
                                        $category->name }}</a>
                                    {{(!$loop->last ? ', ' : '') }}
                                    @endforeach
                                </td>
                                <td>
                                    @can('edit_signs')
                                    <a href="{{ route('admin.signs.edit', $sign->id) }}">Edit</a>
                                    @endcan
                                </td>
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