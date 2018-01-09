@extends('adminlte::page')

@section('title', 'Account')

@section('content_header')
    <h1>{{ $modify === 1 ? 'Edit Profile' : 'Create Account'}}</h1>
@stop

@section('content')
<form action="{{ $modify === 1 ? route('save_account', ['id'=>$id]) : route('create_account')}}"
    method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
            <label>Title</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 {{ $errors->first('name') != '' ? 'has-error' : '' }}">
            <input name="title" type="text" id="title" class="form-control"
                value="{{ old('title') ? old('title') : $title  }}">
            <span class="error help-block">{{ $errors->first('title') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label>Due date</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input name="due_date" type="text" id="due_date" class="date form-control date-time"
                value="{{ old('due_date') ? old('due_date') : $due_date  }}" readonly>
            <input name="due_time" type="text" id="due_time" class="form-control date-time"
                value="{{ old('due_time') ? old('due_time') : $due_time  }}" readonly>
            <span class="error help-block">{{ $errors->first('due_date') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label>Priority</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
           @foreach(Common::getPriorityList() as $priority_color)
               <span style="background-color:{{$priority_color}}"
                    class="priority p-{{$loop->index}}" onclick="setPriority({{$loop->index}})"></span>
                {{--  <label class="container-cb">
                    <input type="radio"  class="priority" />
                    <span class="checkmark" style="background-color:{{$priority}}"></span>
                </label>  --}}
           @endforeach
           <input type="hidden" name="priority" id="priority"
            value="{{ old('priority') ? old('priority') : $priority  }}"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label>Description</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input name="description" type="text" id="description" class="form-control"
                value="{{ old('description') ? old('description') : $description  }}">
            <span class="error help-block">{{ $errors->first('description') }}</span>
        </div>
    </div>

    <input type="submit" class="btn btn-primary" id="create-to-do-list"
        name="create-to-do-list" onclick="disableButton()" value="Add" />
    <a href="{{ route('to_do_list') }}" class="btn btn-default">Cancel</a>
</form>
@stop

@section('css')
    <style>
       
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {

        });

        function disableButton() {
            $(':input[type="submit"]').prop('disabled', true);
            $('form').submit();
        }
    </script>
@stop
