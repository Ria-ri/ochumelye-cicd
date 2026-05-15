<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Очумелые ручки')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
</head>

<body @if(Route::is('cabinet')) class="dp" @endif>
    <div class="header">
        <div class="row grid middle between">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="logo" style="border: none;">
                </a>
            </div>
            <div class="title">
                Клуб любителей творчества «ОчУмелые ручки»
            </div>
            <div class="auth" style="display: flex; align-items: center; gap: 10px;">
    @auth
        <span style="color:#00044c; padding:5px 10px; white-space: nowrap;">{{ auth()->user()->name }}</span>
        @if(auth()->user()->isMaster())
            <a href="{{ route('cabinet') }}" style="color:#00044c; text-decoration:none; padding:5px 10px; background:#eef2f7; border-radius:20px;">Личный кабинет</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" style="background:none; border:none; color:#00044c; font-weight:bold; cursor:pointer; padding:5px 10px;">Выход</button>
        </form>
    @else
        <a href="{{ route('login') }}" style="color:#00044c; text-decoration:none;">Вход</a>
    @endauth
</div>
        </div>
    </div>

    

    <div class="main">
        @yield('content')
    </div>

    @if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px; margin:10px auto; max-width:1100px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background:#f8d7da; color:#721c24; padding:10px; margin:10px auto; max-width:1100px;">
        {{ session('error') }}
    </div>
@endif

@if(session('info'))
    <div style="background:#d1ecf1; color:#0c5460; padding:10px; margin:10px auto; max-width:1100px;">
        {{ session('info') }}
    </div>
@endif

    <div class="row row--nogutter">
        <div class="line"></div>
    </div>
    <div class="footer">
        <div class="row">
            <div class="row--small grid between">
                <div class="address">Наш адрес: Ленина, 15</div>
                <div class="tel">Тел: 88005553535</div>
                <div class="copy">(с) Copyright, 2026</div>
            </div>
        </div>
    </div>
    @if(Route::is('cabinet'))
<style>
    .main .row--small {
        padding-top: 120px !important;
    }
    .driver-page-photo {
        margin-top: 0 !important;

    }
    .driver-page-name {
        left: 10px ;
        text-align: center;
        color: #ffffff;
    }
    .driver-page-text {
        margin-top: 0 !important;
        padding-left: 0 !important;
    }
    .driver-page-table {
        width: 100%;
    }
</style>
@endif
</body>
</html>