@extends('adminlte::page')

@section('title', 'To Do List')

@section('content_header')
    <h1>{{ $modify === 1 ? 'Edit To Do List' : 'Create To Do List'}}</h1>
@stop

@section('content')
<div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))

    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close msg-close" data-dismiss="alert" aria-label="close">&times;</a></p>
    @endif
    @endforeach
</div>
<form action="{{ $modify === 1 ? route('save_to_do_list', ['id'=>$id]) : route('create_to_do_list')}}"
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
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.css">
    <style>
        .date-time {
            width: 250px;
            background-color: #fff;
            display: inline-block;
        }

        .priority {
            width: 30px;
            height: 40px;
            float: left;
            margin-right: 5px;
        }

        .priority:hover {
            cursor: pointer;
        }

        .selected {
            border: 4px solid #3c8dbc;
        }
    </style>
@stop

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdn.jsdelivr.net/jquery.ui.timepicker.addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#due_date").datepicker({
                dateFormat: "yy-mm-dd"
            });
            $("#due_time").timepicker();

            var priority = $("#priority").val();
            if (priority != "") {
                $('.p-' + priority).addClass("selected");    
            } else {
                $('.p-0').addClass("selected");
            }

            setTimeout(function() {
                $(".flash-message").empty();
            }, 1000);
        });

        function disableButton() {
            $(':input[type="submit"]').prop('disabled', true);
            $('form').submit();
        } 

        function setPriority($priority) {
            $("#priority").val($priority);
            $(".priority").removeClass("selected");
            $(".p-" + $priority).addClass("selected");
        }
    </script>
@stop
