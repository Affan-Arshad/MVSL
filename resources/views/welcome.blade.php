@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">MVSL</div>

                <div class="card-body">
                    <a href="{{ route('login') }}">{{ __('Login') }}</a> to continue<br>
                    Email: affan-arshad@live.com<br>
                    Password: mvsladmin
                </div>
            </div>
        </div>
    </div>
</div>
@endsection