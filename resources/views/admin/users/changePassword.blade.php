@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Change Password</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('changePassword') }}" method="POST">
                        @csrf

                        <div class="card-block">

                            <div class="form-group">
                                <label>Current Password</label><br>
                                <input value="" name="current_password" type="password" class="form-control peakable"
                                       required />
                            </div>
                            <div class="form-group">
                                <label>New Password</label><br>
                                <input name="new_password" type="password" class="form-control peakable" required />
                            </div>

                            <div class="form-group">
                                <label>Confirm New Password</label><br>
                                <input name="new_password_confirmation" type="password" class="form-control peakable"
                                       required />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Submit</button>
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