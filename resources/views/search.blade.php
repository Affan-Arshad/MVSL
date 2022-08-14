@extends('layouts.app')

@section('content')
<!-- Full Page Image Header with Vertically Centered Content -->
<div class="page-center">
  <div class="container h-100">
    <div class="row h-100 align-items-center">
      <div class="col-12 text-center">
        <form action="{{ route('signs.index') }}">
          <div class="form-row">
            <div class="col">
              <input name="q" type="text" id="search" class="col form-control" placeholder="Search" required autofocus>
            </div>
            <div class="col-1">
              <button class="form-control">Search</button>
            </div>
          </div>
        </form>
        <div class="text-left mt-4"><a href="{{ route('signs.index') }}">Or Browse all signs</a></div>
      </div>
    </div>
  </div>
</div>
@endsection