@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Sign</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form action="{{ route('admin.signs.store') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-block">

                            <div class="form-group">
                                <label>Video</label>
                                <input type="file" class="form-control" placeholder="Upload Video" name="video"
                                       required>
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
                                <textarea class="form-control" name="explanation"></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Add</button>
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
</script>
@endsection