@extends('adminlte::page')

@section('title', 'To Do List')

@section('content_header')
    <h1>Change Password</h1>
@stop

@section('content')
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))

    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close msg-close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    @endforeach
</div>
<form action="{{ route('submit_change_password')}}"
    method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
            <label>Old Password</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 {{ $errors->first('old_password') != '' ? 'has-error' : '' }}">
            <input name="old_password" type="password" id="old_password" class="form-control"
                value="{{ old('old_password') ? old('old_password') : $old_password  }}">
            <span class="error help-block">{{ $errors->first('old_password') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label>New Password</label>
        </div>
    </div>
    <div class="row">
            <div class="col-md-12 {{ $errors->first('password') != '' ? 'has-error' : '' }}">
                <input name="password" type="password" id="password" class="form-control"
                    value="{{ old('password') ? old('password') : $password  }}">
                <span class="error help-block">{{ $errors->first('password') }}</span>
            </div>
        </div>
    <div class="row">
        <div class="col-md-12">
            <label>Confirm New Password</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 {{ $errors->first('password') != '' ? 'has-error' : '' }}">
            <input name="confirm_password" type="password" id="confirm_password" class="form-control"
                value="{{ old('confirm_password') ? old('confirm_password') : $confirm_password  }}">
            <span class="error help-block">{{ $errors->first('confirm_password') }}</span>
        </div>
    </div>

    <input type="submit" class="btn btn-primary" id="submit_change_password"
        name="submit_change_password" onclick="disableButton()" value="Save" />
    <a href="{{ route('to_do_list') }}" class="btn btn-default">Cancel</a>
</form>
@stop

@section('css')
    <style>
    </style>
@stop

@section('js')
    <script>
        function disableButton() {
            $(':input[type="submit"]').prop('disabled', true);
            $('form').submit();
        } 
    </script>
@stop
