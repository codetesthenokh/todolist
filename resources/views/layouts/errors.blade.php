<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Something wrong..</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #error-wrapper {
            display: flex;
            position: fixed;
            height: 100%;
            width: 100%;
            align-items: center;
            justify-items: center;
        }

        #error-content {
            text-align: right;
        }

        .error-code {
            font-size: 150px;
        }
    </style>
</head>
<body>
    <div class="row" id="error-wrapper">
        <div class="col-md-6" id="error-content">
            <h1 class="error-code">
                @yield('error_code')
            </h1>
            @yield('error_description')
        </div>
        <div class="col-md-6">
            <a class="btn btn-primary" href="{{ route('to_do_list') }}">
                Back to home
            </a>
        </div>
    </div>
</body>
</html>