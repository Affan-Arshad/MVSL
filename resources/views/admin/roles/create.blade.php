@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">{{ isset($role) ? 'Edit Role' : 'Add Role' }}</h4>
                    @if (isset($role))

                    <a class="btn btn-danger text-white" href="#" onclick="handleDelete(event)">Delete
                        Role</a>
                    <form id="deleteForm" action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                </div>

                <div class="card-body">

                    <form action="{{ isset($role) ? route('admin.roles.update', $role->id) : route('admin.roles.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Change method if update --}}
                        @if (isset($role))
                        @method('PUT')
                        @endif

                        <div class="card-block">

                            <div class="form-group">
                                <label>Name</label><br>
                                <input value="{{ old('name', isset($role) ? $role->name : '') }}" class="form-control"
                                       type="text" name="name" />
                            </div>

                            <fieldset class="form-group border px-4 pb-4">
                                <legend class="w-auto px-2">Permissions</legend>
                                <div class="d-flex flex-wrap gap-20 justify-content-between">
                                    @foreach ($permissions as $group)
                                    <div class="d-flex flex-column">
                                        <label>
                                            <b>{{ $group[0]->group }}</b>
                                        </label>
                                        <div>
                                            @foreach ($group as $permission)
                                            <label class="ml-3">
                                                <input type="checkbox" name="permissions[]" id=""
                                                       value="{{ $permission->name }}" {{ isset($role) ?
                                                       ($role->hasPermissionTo($permission->name) ? 'checked' : '') : ''
                                                }}/>
                                                {{ $permission->name }}
                                            </label><br>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </fieldset>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ isset($role) ? 'Submit Changes' : 'Add'
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

@section('additional_css')
<link rel="stylesheet" href="/css/select2.min.css">
@endsection
@section('additional_js')
<script>
    const handleDelete = (e) => {
    e.preventDefault();
    const del = confirm('DELETE this role?');
    if(del) {
        const form = document.querySelector('#deleteForm');
        form.submit();
    }
}
</script>
@endsection