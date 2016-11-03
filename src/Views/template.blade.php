<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8">

        <title>@yield('title')</title>
        <meta name="description" content="The HTML5 Herald">
        <meta name="author" content="SitePoint">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Miriam+Libre|Source+Sans+Pro:300,400" rel="stylesheet">

        <style>
            body {
                font-family: 'Miriam Libre', sans-serif;
            }
            b {
                font-family: 'Miriam Libre', sans-serif !important;
            }
            .title {
                font-size: 75px;
            }
            .subtitle {
                font-size: 30px;
            }
            .statistic {
                font-size: 40px;
            }
            .statistic-text {
                font-size: 20px;
            }

            .card {
                border-color: #373a3c;
            }
        </style>

        {!! ConsoleTVs\Charts\Charts::assets() !!}

        <!--[if lt IE 9]>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
        <![endif]-->
    </head>

    <body>
        <center>
            <br><br>
            <span class='title'>@yield('bigTitle')</span><br>
            <span class='subtitle'>@yield('subtitle')</span>
            <br><br>
            @yield('actions')
            @if(session('links.password') && Crypt::decrypt(session('links.password')) == config('links.password'))
                <a class="btn btn-secondary" href="{{ route('links::logout') }}" class='logout'>Logout</a>
            @endif
            <br><br>
        </center>

        <div class="container">
            @yield('content')
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" integrity="sha384-3ceskX3iaEnIogmQchP8opvBy3Mi7Ce34nWjpBIwVTHfGYWQS9jwHDVRnpKKHJg7" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" integrity="sha384-XTs3FgkjiBgo8qjEjBk0tGmf3wPrWtA6coPfQDfFEY8AnYJwjalXCiosYRBIBZX8" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
        <script>
            $(function () {
              $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
    </body>
</html>
