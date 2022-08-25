@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">{{ isset($sign) ? 'Edit Sign' : 'Add Sign' }}</h4>
                    @if (isset($sign))

                    <a class="btn btn-danger text-white" href="#" onclick="handleDelete(event)">Delete
                        Sign</a>
                    <form id="deleteForm" action="{{ route('admin.signs.destroy', $sign->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                </div>

                <div class="card-body">

                    <form action="{{ isset($sign) ? route('admin.signs.update', $sign->id) : route('admin.signs.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Change method if update --}}
                        @if (isset($sign))
                        @method('PUT')
                        @endif

                        <div class="card-block">

                            <div class="form-group">
                                <label>Video</label>
                                @if (isset($sign) && $sign->video != '')
                                <video width=100% controls>
                                    <source src="{{ \Storage::url($sign->video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                Replace Video: <input type="file" name="video" class="replace-video">
                                {{-- <div class="replace_video-wrapper">
                                    <button class="replace_video-button">
                                        <a href="javascript: void(0)">Replace Video</a>
                                    </button>
                                    <input type="file" name="video" class="replace_video-input" />
                                </div> --}}
                                @else
                                <input type="file" class="form-control" placeholder="Upload Video" name="video">
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Meaning</label><br>
                                <select class="select2-meaning form-control" name="meaning[]" multiple>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Category</label><br>
                                <select class="select2-category form-control" name="category[]" multiple>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Explanation</label>
                                <textarea class="form-control" name="explanation">{{ isset($sign) ? $sign->explanation :
                                    '' }}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">{{ isset($sign) ? 'Submit Changes' : 'Add'
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
<script src="/js/select2.min.js"></script>
<script>
    // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.select2-meaning').select2({
        tags: true,
        data: @json($meaningsData),
        // minimumInputLength: 1
    });

    $('.select2-category').select2({
        tags: true,
        data: @json($categoriesData),
        // minimumInputLength: 1
    });
});

const handleDelete = (e) => {
    e.preventDefault();
    const del = confirm('DELETE this sign?');
    if(del) {
        const form = document.querySelector('#deleteForm');
        form.submit();
    }
}
</script>
@endsection