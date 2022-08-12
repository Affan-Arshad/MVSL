@extends('layouts.app')

@section('content')
<!-- Full Page Image Header with Vertically Centered Content -->
<header class="masthead" style="margin-top: -56px;">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 text-center">
                <form>
                    <div class="form-row">
                        <div class="col">
                            <input type="text" id="search" class="col form-control" placeholder="Search" required
                                   autofocus>
                        </div>
                        <div class="col-1">
                            <button class="form-control">Services</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
@endsection