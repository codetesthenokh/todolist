@extends('layouts.auth')
@section('title')
Register
@endsection
@section('form')        
    <form id="register" action="{{route('create_account')}}"
        method="post">
        {{ csrf_field() }}
        <h1>Register</h1>
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close msg-close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
            @endforeach
        </div>
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
        <div class="row">
            <div class="col-md-12">
                <label>Email</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input name="email" type="email" id="email" class="form-control"
                    value="{{ old('email') ? old('email') : $email  }}">
                <span class="error help-block">{{ $errors->first('email') }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>Password</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input name="password" type="password" id="password" class="form-control"
                    value="{{ old('password') ? old('password') : $password  }}">
                <span class="error help-block">{{ $errors->first('password') }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>Confirm Password</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input name="confirmPassword" type="password" id="confirmPassword" class="form-control"
                    value="{{ old('confirmPassword') ? old('confirmPassword') : $confirmPassword  }}">
                <span class="error help-block">{{ $errors->first('confirmPassword') }}</span>
            </div>
        </div>
    
        <input type="submit" class="btn btn-primary" id="createUser"
            name="createUser" onclick="disableButton()" value="Register" />
        <a href="{{ route('home') }}" class="btn btn-default">Cancel</a>
    </form>
@endsection
@section('style')
<style>
    @media(min-width: 768px) {
        #register {
            width: 30%;
        }
    }
</style>
@endsection
@section('script')
    <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".flash-message").empty();
                }, 3000);
            });
    </script>
@endsection