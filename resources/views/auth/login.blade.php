@extends('layouts.app')

@section('content')
<div class="row row--nogutter top-line">
    <div class="line"></div>
</div>
<div class="main">
    <div class="row">
        <div class="row--small">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h2>Авторизация</h2>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                    <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <button class="btn" type="submit">Войти</button>
                </div>
                <div>Нет аккаунта? <a href="{{ route('register') }}">Регистрация</a></div>
            </form>
        </div>
    </div>
</div>
@endsection