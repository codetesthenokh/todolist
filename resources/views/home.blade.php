@extends('layouts.auth')
@section('title')
Home
@endsection
@section('form')
    <div id="appDetails">
        <h1>To Do List</h1>
        <p>Make your tasks organized well!!</p>
    </div>
    <div>
        <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
        <a href="{{ route('register') }}" class="btn btn-default">Register</a>
    </div>
@endsection
@section('style')
    <style>
        #appDetails {
            margin-right: 20px;
        }
    </style>
@endsection
