<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
        integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
        crossorigin="anonymous" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/UIjs/themes/base/jquery-ui.css') }}">
    @stack('third_party_stylesheets')

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Main Header -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('images/logo.png')}}" class="user-image img-circle elevation-2"
                            alt="User Image">
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-primary">
                            <img src="{{asset('images/logoalt.png')}}" class="img-circle elevation-2" alt="User Image">
                            <p>
                                @if(Auth::user()!=null)
                                {{ Auth::user()->name }}
                                <small>{{ Auth::user()->created_at->format('M. Y') }}</small>
                                @endif
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
                            <a href="#" class="btn btn-default btn-flat float-right"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Déconnexion
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <section id="loading" class="loading">
            <div id="loading-content" class="loading-content"></div>
        </section>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="padding: 20px;" id="page-content">

            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.0.5
            </div>
            <strong>Copyright &copy; 2024 <a class="copyrith" href="https://www.africanlease.com/">AFRICAN LEASE
                    TOGO</a>.</strong> Tous droits reservés
        </footer>
    </div>

    <script src="{{asset('/vendor/jquery/jquery.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{asset('/vendor/UIjs/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('/vendor/UIjs/jquery.ui.datepicker-fr.js') }}"></script>

    @stack('third_party_scripts')

    @stack('page_scripts')

    <script>
    function showLoading() {
        document.querySelector('#loading').classList.add('loading');
        document.querySelector('#loading-content').classList.add('loading-content');
    }

    // Cache le spinner de chargement
    function hideLoading() {
        document.querySelector('#loading').classList.remove('loading');
        document.querySelector('#loading-content').classList.remove('loading-content');
    }

    showLoading();
    window.addEventListener('load', function() {
        // Cache le spinner une fois le chargement de la page terminé
        hideLoading();
       // alert("test");

        // Affiche le contenu de la page
        document.getElementById('page-content').style.display = 'block';
    });

    // Affiche le spinner au moment de la soumission du formulaire
    </script>


</body>

</html>