@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Users</h4>
                    <a class="btn btn-success text-white" href="{{ route('admin.users.create') }}">+ Add user</a>
                </div>

                <div class="card-body">
                    <table class="table m-0 border">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            @if (!$user->hasRole('Super-Admin'))
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                    {{ $role->name }}
                                    {{ !$loop->last ? ' / ' : '' }}
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}">Edit roles</a>
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