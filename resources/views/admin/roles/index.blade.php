@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Roles</h4>

                    @can('create_roles')
                    <a class="btn btn-success text-white" href="{{ route('admin.roles.create') }}">+ Add role</a>
                    @endcan
                </div>

                <div class="card-body">
                    <table class="table m-0 border">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>User count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            @if ($role->name != 'Super-Admin')
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->users()->count() }}</td>
                                <td>
                                    @can('edit_roles')
                                    @if ($role->name != "User")
                                    <a href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>
                                    @endif
                                    @endcan
                                </td>
                            </tr>
                            @endif
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