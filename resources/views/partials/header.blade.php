<header class="main-header">
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- start: CONTAINER -->
        <div class="container">
            <div class="navbar-header">
                <!-- start: LOGO -->
                <a href="{{ route('home') }}" class="navbar-brand"><strong>gamify</strong> v3</a>
                <!-- end: LOGO -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <!-- start: TOP LEFT NAVIGATION MENU -->
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                @include('partials.sidebar')
            </div>
            <!-- end: TOP LEFT NAVIGATION MENU -->
            <!-- start: TOP RIGHT NAVIGATION MENU -->
            <div class="navbar-custom-menu">
                <!-- start: TOP NAVIGATION MENU -->
                <ul class="nav navbar-nav">

                    <!-- start: NOTIFICATION DROPDOWN -->
                    <!-- TODO -->
                    <!-- end: NOTIFICATION DROPDOWN -->

                    <!-- start: USER DROPDOWN -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ Auth()->user()->profile->getAvatarURL() }}" class="user-image"
                                 alt="{{ trans('user/profile.avatar') }}"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ Auth()->user()->profile->getAvatarURL() }}" class="img-circle"
                                     alt="{{ trans('user/profile.avatar') }}"/>
                                <p>
                                    {{ Auth()->user()->name }} - {{ Auth()->user()->getCurrentLevelName() }}
                                    <small>Member since {{ date("M Y", strtotime(Auth()->user()->created_at)) }}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="col-xs-12 text-center">
                                    <a href="#">{{ trans('site.my_achievements') }}</a>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('profiles.show', Auth::user()->username) }}"
                                       class="btn btn-default btn-flat">
                                        {{ trans('site.my_profile') }}
                                    </a>
                                </div>
                                <div class="pull-right">
                                    {!! Form::open(['route' => 'logout']) !!}
                                    {!! Form::button(trans('auth.logout'), ['type' => 'submit', 'class' => 'btn btn-default btn-flat']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- end: USER DROPDOWN -->
                </ul>
                <!-- end: TOP RIGHT NAVIGATION MENU -->
            </div>
        </div>
        <!-- end: CONTAINER -->
    </nav>
</header>

