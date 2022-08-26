<div class="container pt-4">

    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    @if ($messages = Session::get('messages'))
    @foreach ($messages as $message => $type)
    <div class="alert alert-{{ $type ? $type : 'info' }} alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endforeach
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        @foreach ($errors->all() as $error)
        <strong>{{ $error }}</strong>
        @endforeach
        </ul>
    </div>

    @endif
</div>