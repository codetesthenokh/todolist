@extends('layouts.auth')
@section('title')
Log in
@endsection
@section('form')        
    <form action="{{route('login_auth')}}"
        method="post">
        {{ csrf_field() }}
        <h1>Log in</h1>
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))

            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close msg-close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>Email</label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 {{ $errors->first('email') != '' ? 'has-error' : '' }}">
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
    
        <input type="submit" class="btn btn-primary" id="login"
            name="login" onclick="disableButton()" value="Log in" />
        <a href="{{ route('home') }}" class="btn btn-default">Cancel</a>
    </form>
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
