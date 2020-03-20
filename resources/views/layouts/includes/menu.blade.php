@php
    use App\Helpers\LERHelper;
    $notifications = LERHelper::getMyNotifications(@Auth::user()->id);
@endphp

@if(@Auth::user()->role == "admin")
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
@elseif(@Auth::user()->role == "employee")
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
@elseif(@Auth::user()->role == "employer")
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
@else
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
@endif
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            Learning
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @if(Auth::user()->role == "employer")
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Candidate Data <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('applied-candidate') }}">
                                    {{ __('Applied Candidates') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('view-subscribed-employee') }}" title="Candidates Subscribed to my jobs">
                                    {{ __('Candidates Subscribed') }}
                                </a>
                            </div>
                        </li>
                    @endif
                    @if((Auth::user()->role == "employee" || Auth::user()->role == "employer") && @$notifications['count'] != 0)
                    <li class="nav-item dropdown" id="notificationLI">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle notificationLI" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Notifications <span class="badge badge-primary" id="notificationCount">{{ (@$notifications['count'] != 0) ? @$notifications['count']: '' }}</span><span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" id="notificationDiv">
                                @if(!empty($notifications['notification']))
                                    @foreach($notifications['notification'] as $notification)
                                        <a href="#" class="dropdown-item">{!! $notification !!}</a>
                                    @endforeach
                                @endif
                            </div>
                        </li>
                    @endif
                    @if(Auth::user()->role == "employee")
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Job Data <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('jobs') }}">
                                    {{ __('List Jobs') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('applied-job') }}">
                                    {{ __('Applied Jobs') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('view-subscribed-employer') }}" title="Subscribed to employers">
                                    {{ __('Subscribed Employers') }}
                                </a>
                            </div>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} ({{ Auth::user()->role }}) <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            @if(Auth::user()->role == "admin")
                                <a class="dropdown-item" href="{{ route('list-user') }}">
                                    {{ __('List Users') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('list-jobs') }}">
                                    {{ __('List Jobs') }}
                                </a>
                            @endif
                            @if(Auth::user()->role == "employer")
                                <a class="dropdown-item" href="{{ route('list-active-user') }}">
                                    {{ __('List User') }}
                                </a>
                            @endif
                            @if(Auth::user()->role == "employer")
                                <a class="dropdown-item" href="{{ route('list-active-jobs') }}">
                                    {{ __('List My Jobs') }}
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                {{ __('Profile') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('change-password') }}">
                                {{ __('Change Password') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<script type="text/javascript">
    $(document).ready(function(){
        $("#notificationLI").click(function(){
            $("#notificationCount").hide();
        });
        $(".notificationRMV").click(function(){
            var id = $(this).attr('data-arr');
            var _url = "{{ route('mark-as-read') }}";
            formData = { 
                        "id": id,
                        "_token": "{{ csrf_token() }}",
                       };
            if(id){
                $.ajax({
                    url: _url,
                    type: "POST",
                    data: formData,
                    success: function(data){
                        data = $.parseJSON(data);
                        if(data.status == 1){
                            $(this).hide();
                            alert("Marked as Read");
                        } else{
                            alert("Some error try after some time !");
                        }
                    }
                });
            } else {
                alert("Not able to do so, missing data");
            }
        });
    });
</script>