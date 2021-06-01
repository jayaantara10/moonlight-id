<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Moonlight</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Moonlight
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Our Products </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="transdrop" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Transaksi</a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="transdrop">
                                <a class="dropdown-item" href="{{ route('my.cart') }}">
                                    <i class="fa fa-shopping-cart"></i> Shopping cart
                                </a>
                                <a class="dropdown-item" href="{{ route('my.transaction') }}">
                                    <i class="fa fa-list"></i> Transaksi
                                </a>
                            </div>
                        </li>
                    </ul>

                    {{-- YANG DI BAWAH INI JANGAN DI UBAH UBAH --}}
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
                        <li class="nav-item btn-rotate dropdown mr-5">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell">
                                    <div class="dropdown-menu py-3 px-2">
                                    @if ($notif->count()==0)
                                    <p>Tidak Ada Notif</p>
                                    @endif
                                    @foreach($notif as $item)
                                    @php
                                    $data=json_decode($item->data,true);
                                    @endphp
                                    <div style="cursor:pointer;" onclick="readNotif({{$item->id}})" data-notif="{{$item->id}}"class="card mb-1 p-3">{{$data['message']}}</div>
                                    @endforeach
                                    </div>
                                    <form id="bacaNotif" action="/notifikasi/baca" method="post">
                                    @csrf
                                    <input type="hidden" id="notif_id" name="id_notif">
                                    </form>
                                    </i>
                                </a>
                            </li>
                        <li class="nav-item dropdown mr-4">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('user.logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('user-logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="user-logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    @yield('content')
</main>
</div>
<script>
    function readNotif(id){
        $('#notif_id').val(id);
        $('#bacaNotif').submit();
    }
</script>
</body>
</html>
