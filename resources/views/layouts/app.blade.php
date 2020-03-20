<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{!! trans('main.site_title') !!}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    @if(@Auth::user()->role == "employee" || @Auth::user()->role == "employer")
        <script>

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('abbe0cf890cf2df79aaa', {
                cluster: 'ap2',
                forceTLS: true
            });
            var noti_content = '';
            var realTmsg = '';
            var userTyping = '';
            var myuserId = '{{ @Auth::user()->id }}';
            var myuserName = '{{ @Auth::user()->first_name }} {{ @Auth::user()->last_name }}';
            var channel = pusher.subscribe('my-channel');
                channel.bind('job-submitted', function(data) {
                    noti_content = data.message;
                    $("#notificationDiv").append(noti_content);
                    console.log(data);
                    if(data.main_message != '' && (data.to_idonly == myuserId)){
                        realTmsg = '<div class="card-body mt-4 light"><div class="card"><div class="card-body"><h5 class="card-title">'+data.from_id+'<span class="small text-muted pull-right">'+data.datetimes+'</span></h5><p class="card-text"><b>'+data.main_message+'</b></p></div></div></div>';
                        $(".mainMsgClass").append(realTmsg);
                        $('#messagewindow').animate({
                          scrollTop: $('#messagewindow')[0].scrollHeight
                        }, 2000);
                    }
                    if(data.typing_message != '' && data.typing_message != undefined){
                        userTyping = data.typing_message+" is Typing...";
                        if(myuserName != data.typing_message){
                            $("#userTypingSpan").html("<i>"+userTyping+"</i>");
                        }
                    } else {
                        $("#userTypingSpan").text("");
                    }
            });
        </script>
    @endif
</head>
<body style="background-color: #ca7ba342;">
    <div id="app">
        @include('layouts.includes.menu')

        <main class="py-4">
            @include('layouts.includes.alert')
            @yield('content')
        </main>

        <nav class="navbar fixed-bottom navbar-expand-sm navbar-dark bg-dark">
            <a class="navbar-brand" href="{{ url('/') }}">Learning</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <!-- <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                    <li class="nav-item dropup">
                        <a class="nav-link dropdown-toggle" href="https://getbootstrap.com/" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropup</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown10">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                    </li>
                </ul> -->
            </div>
        </nav>  
    </div>
</body>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
</html>
