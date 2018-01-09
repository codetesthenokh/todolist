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
<form action="{{ route('submit_edit_profile')}}"
    method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
            <label>Name</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 {{ $errors->first('name') != '' ? 'has-error' : '' }}">
            <input name="name" type="text" id="name" class="form-control"
                value="{{ old('name') ? old('name') : $name  }}">
            <span class="error help-block">{{ $errors->first('name') }}</span>
        </div>
    </div>

    <input type="submit" class="btn btn-primary" id="submit_edit_profile"
        name="submit_edit_profile" onclick="disableButton()" value="Save" />
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
