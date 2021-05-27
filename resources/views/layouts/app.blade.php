<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <!-- Styles -->
    {{-- <link  rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/aplicacio.css') }}">

</head>

<body>
    <div id="app">
        <header class="header">
            <nav id="menu" class="navbar navbar-expand-md navbar-light shadow-sm ">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="/img/logo.png" alt="" width="175px">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('productos') }}">Productos</a>
                            </li>
                            @guest
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('cesta') }}">Cesta</a>
                                </li>

                            @endguest
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                            @else
                                <li class="nav-item dropdown ">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right colorverd"
                                        aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Cerrar Session') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                        @if (Auth::user()->esAdmin)
                                            <a class="dropdown-item" href="{{ route('gestioproductes') }}">
                                                {{ __('Gestion Productos') }}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('gestiocomandes') }}">
                                                {{ __('Gestion Comandas') }}
                                            </a>
                                            <a class="dropdown-item" href="{{ route('gestiousuaris') }}">
                                                {{ __('Gestion Usuarios') }}
                                            </a>
                                        @else
                                            <a class="dropdown-item" href="{{ route('gestiocomandes') }}">
                                                {{ __('Ver comandas') }}
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            @yield('content')
        </main>
    </div>
    <footer class="footer">
        <div class="container bottom_border centrado">
            <div class="row">
                <div class=" col-sm-6 col-md-6 col-sm-6  col-12 col">
                    <h5 class="headin5_amrc col_white_amrc pt2">CONTACTO</h5>
                    <!--headin5_amrc-->
                    <p><i class="fa fa-phone"></i> +34 680 749 494</p>
                    <p><i class="fa fa-phone"></i> +34 665 837 241</p>
                    <p><i class="fa fa-envelope"></i> banyantreeservice@gmail.com</p>
                    <ul class="footer_ul_amrc">

                    </ul>
                </div>

                <div class=" col-sm-6 col-md-6  col-12 col">
                    <h5 class="headin5_amrc col_white_amrc pt2">INFORMACIÓN</h5>
                    <!--headin5_amrc-->
                    <ul class="footer_ul_amrc">
                        <p class="mb10"> <a href="{{ url('/politica') }}">Politica</a>
                        <p>

                            {{-- @foreach ($pages as $page)
                    @if ($page->deleted == 0)
                    <p class="mb10">  <a href="{{ url('pages/'.$page->id) }}">{{ $page->title }}</a> <p>
                    @else
                    
                    @endif 
                @endforeach --}}
                    </ul>
                    <!--footer_ul_amrc ends here-->
                </div>

                <div class=" col-sm-4 col-md-4  col-12 col">


                    <!--footer_ul_amrc ends here-->
                </div>



            </div>
        </div>


        <div class="container">
            <ul class="foote_bottom_ul_amrc nav nav-tabs nav-justified mb-3">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Entrar') }}</a>
                        </li>
                    @endif


                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">{{ __('Inicio') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('productos') }} ">{{ __('Productos') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/cesta">{{ __('Cesta') }}</a>
                    </li>



                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                            @if (Auth::user()->esAdmin)
                                <a class="dropdown-item" href="{{ route('gestioproductes') }}">
                                    {{ __('Gestion Productos') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('gestiocomandes') }}">
                                    {{ __('Gestion Comandas') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('gestiousuaris') }}">
                                    {{ __('Gestion Usuarios') }}
                                </a>
                            @else
                                <a class="dropdown-item" href="{{ route('gestiocomandes') }}">
                                    {{ __('Ver comandas') }}
                                </a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                {{ __('Cerrar Session') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>

            <!--social_footer_ul ends here-->
        </div>
    </footer>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="{{ asset('js/aplicacio.js') }}"></script>
<script src="https://kit.fontawesome.com/8f497d50ac.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</html>
