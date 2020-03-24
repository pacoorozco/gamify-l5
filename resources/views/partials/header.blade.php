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
                @include('partials.user_dropdown')
                <!-- end: USER DROPDOWN -->
                </ul>
                <!-- end: TOP RIGHT NAVIGATION MENU -->
            </div>
        </div>
        <!-- end: CONTAINER -->
    </nav>
</header>
