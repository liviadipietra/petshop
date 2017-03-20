<?php $status_success = Session::get('status_success'); ?>

@if ($status_success != '')
    <!-- Form Error List -->
    <div class="alert alert-success">
        <strong>{{$status_success}}</strong>
    </div>
@endif

<?php $status_error = Session::get('status_error'); ?>

@if ($status_error != '')
    <!-- Form Error List -->
    <div class="alert alert-danger">
        <strong>{{$status_error}}</strong>
    </div>
@endif