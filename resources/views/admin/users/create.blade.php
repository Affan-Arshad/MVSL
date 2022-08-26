@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">{{ isset($user) ? 'Edit User Roles' : 'Add User' }}</h4>
                    @if (isset($user))

                    <a class="btn btn-danger text-white" href="#" onclick="handleDelete(event)">Deactivate
                        User</a>
                    <form id="deleteForm" action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                </div>

                <div class="card-body">

                    <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Change method if update --}}
                        @if (isset($user))
                        @method('PUT')
                        @endif

                        <div class="card-block">

                            <div class="form-group">
                                <label>Name</label><br>
                                <input value="{{ old('name', isset($user) ? $user->name : '') }}" name="name"
                                       type="text" class="form-control" {{ isset($user) ? 'disabled' : '' }} required />
                            </div>

                            <div class="form-group">
                                <label>Email</label><br>
                                <input value="{{ old('email', isset($user) ? $user->email : '') }}" name="email"
                                       type="email" class="form-control" {{ isset($user) ? 'disabled' : '' }}
                                       required />
                            </div>

                            @if (!isset($user))
                            <div class="form-group">
                                <label>Password</label><br>
                                <input name="password" type="password" class="form-control peakable" required />
                            </div>

                            <div class="form-group">
                                <label>Confirm Password</label><br>
                                <input name="password_confirmation" type="password" class="form-control peakable"
                                       required />
                            </div>
                            @endif

                            <div class="form-group">
                                <label>Roles</label><br>
                                @foreach ($roles as $role)
                                <label class="user-select-none">
                                    <input value="{{ $role->name }}" type="checkbox" name="roles[]" {{ isset($user) &&
                                           $user->hasRole($role) ? 'checked' : '' }} />
                                    {{ $role->name }}
                                </label>
                                <br>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ isset($user) ? 'Submit Changes' : 'Add'
                                    }}</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_js')
<script type="module">
    import { makePeakable } from '/js/peakable.js'
    makePeakable('.peakable')
</script>
@endsection