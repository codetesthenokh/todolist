{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', 'To do list')

@section('content_header')
    <h1>To Do list</h1>
@stop

@section('content')
    <div id="loadingContainer">
        <div class="loader"></div>
    </div>
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))

        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close msg-close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-9">
            Manage your activities more efficient and faster.
        </div>
        <div class="col-md-3 add-todo">
            <a class="btn btn-primary" href="./todolist/create">
                <i class="fa fa-plus"></i> Add to do list
            </a>
        </div>
    </div>
    @if(count($todolist) > 0)
        @foreach ($todolist as $todo)
            {{--  {{ $todo->title }}  --}}
            <div class="row todo {{ $todo->is_completed != null && $todo->is_completed == 1 ? 'completed-task' : '' }}">
                <div class="col-md-11 col-xs-10">
                    <label class="container-cb">
                        <input type="checkbox" class="completed" onclick="setToDoListComplete({{$todo->id}})"
                            "{{ $todo->is_completed != null && $todo->is_completed == 1 ? " checked disabled " : "" }}" />
                        <span class="checkmark"
                            data-toggle="tooltip"
                            title="{{ $todo->is_completed != null && $todo->is_completed == 1 ? 'Completed!' : 'Check this to mark as completed task' }}">
                        </span>
                    </label>
                    <span class="{{ $todo->is_completed != null && $todo->is_completed == 1 ? 'completed-title title' : 'title' }}"
                            onclick="showDetails({{ $todo->id}})">
                        <span class="priority" style="background-color:{{$priority_list[$todo->priority]}}"></span>
                        <span class="show-details">{{$todo->title}}</span>
                    </span>
                </div>
                {{--  <span>{{ Carbon\Carbon::parse($todo['due_date'])->format('j F Y') }}</span>  --}}
                <div class="col-md-1 col-xs-2 action-cell">
                    <a class="btn btn-default"
                        href="{{route('edit_to_do_list', ['id'=> $todo->id])}}">
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
                <div class="col-md-12 details details-{{$todo->id}}">
                    @if ($todo->description != null)
                    <b>Details:</b> <br />
                    {{$todo->description}} <br />
                    @endif
                    @if ($todo->due_date != null)
                        <b>Due date:</b> <br />
                        {{ Carbon\Carbon::parse($todo->due_date)->format('j F Y h:i') }}
                    @endif
                </div>
            </div>
        @endforeach
    @else
            No items to be shown....
    @endif
@stop

@section('css')
    <style>
        .add-todo {
            text-align: right;
        }
        .action-cell {
            float: right;
            visibility: hidden;
        }

        .title {
            position: relative;
            top: 5px;
        }

        .completed-title {
            text-decoration: line-through;
        }

        .show-details {
            cursor: pointer;
        }

        .details {
            margin-top: 20px;
            display:none;
        }

        .row.todo {
            border: 1px solid #ccc;
            margin: 5px 0px;
            padding: 3px 5px;
            border-radius: 8px;
            background-color:#D1E5F1;
        }

        .row.todo.completed-task {
            background-color:steelblue;
        }

        .row.todo.completed-task .container-cb input {
            cursor: normal;
        } 

        .priority {
            width: 20px;
            height: 20px;
            float: left;
            margin-right: 10px;
            position: relative;
            top: 4px;
        }
        
        .priority:hover {
            cursor: pointer;
        }
        
        .container-cb {
            position: relative;
            float: left;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .container-cb input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
            border-radius: 15px;
        }

        .container-cb:hover input ~ .checkmark {
            background-color: #ccc;
            border-radius: 15px;
        }

        .container-cb input:checked ~ .checkmark {
            background-color: #2196F3;
            border-radius: 15px;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .container-cb input:checked ~ .checkmark:after {
            display: block;
            border-radius: 15px;
        }

        .container-cb .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
            border-radius: 15px;
        }

        .alert a.msg-close {
            text-decoration: none;
        }

        #loadingContainer {
            display:none;
            width: 100%;
            height: 100%;
            position: absolute;
            top:0;
            left: 0;
            align-items: center;
            justify-content: center;
            background-color: #ddd;
            opacity: 0.7;
            z-index: 99999;
        }
 
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite; /* Safari */
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 767px) {
            .add-todo {
                margin-top: 5px;
            }
        }
    </style>
@stop

@section('js')
    <script>
            
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip(); 
            setTimeout(function() {
                $(".flash-message").empty();
            }, 1000);
        });

        function showDetails(id) {
            $(".details-" + id).toggle();
        }

        function setToDoListComplete(id) {
            $("#loadingContainer").css("display", "flex");
            $.ajax({
                type: "GET",
                url: '/todolist/setcomplete/' + id, // This is what I have updated
            }).done(function() {
                window.location.reload();
            });
        }
    </script>
@stop