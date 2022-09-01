@if (session('status'))
<div class="status container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>

        </div>
    </div>
</div>
@endif

@if ($messages = Session::get('messages'))
<div class="messages container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @foreach ($messages as $message => $type)
            <div class="alert alert-{{ $type ? $type : 'info' }} alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endif

@if ($errors->any())
<div class="errors container pt-4">
    <div class="row justify-content-center">
        <div class="col-md-12">

            @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $error }}</strong>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endif