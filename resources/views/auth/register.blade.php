@extends('layouts.app')
@if($errors->any())
    <div style="background:#f8d7da; color:#721c24; padding:15px; margin-bottom:20px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@section('content')
<div class="row row--nogutter top-line">
    <div class="line"></div>
</div>
<div class="main">
    <div class="row">
        <div class="row--small">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h2>Регистрация</h2>
                <div class="form-group">
                    <label>ФИО</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    @error('name')
                    <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
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
                    @error('password') 
                    <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Подтверждение пароля</label>
                    <input type="password" name="password_confirmation" required>
                </div>
                <div class="form-group">
                    <label>Телефон</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" placeholder="8-ххх-ххх-хх-хх" required>
                    @error('phone')
                        <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>

                <script>
                    document.getElementById('phone')?.addEventListener('input', function(e) {
                        let val = e.target.value.replace(/\D/g, ''); // только цифры
                        if (val.length === 0) {
                            e.target.value = '';
                            return;
                        }
                        if (val[0] !== '8') {
                            val = '8' + val.slice(1);
                        }
                        // Ограничиваем максимум 11 цифр (8 + 10 цифр)
                        if (val.length > 11) val = val.slice(0, 11);
                        //  первая цифра 8
                        let formatted = val.substring(0,1);
                        if (val.length > 1) formatted += '-' + val.substring(1,4);
                        if (val.length > 4) formatted += '-' + val.substring(4,7);
                        if (val.length > 7) formatted += '-' + val.substring(7,9);
                        if (val.length > 9) formatted += '-' + val.substring(9,11);
                        e.target.value = formatted;
                    });
                </script>
                <div class="form-group">
                    <button class="btn" type="submit">Зарегистрироваться</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection