@extends('layouts.app')
@if ($errors->any())
    <div class="alert alert-danger" style="background:#f8d7da; color:#721c24; padding:15px; margin-bottom:20px;">
        <ul style="margin:0;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@section('content')
<div class="row row--nogutter top-line"><div class="line"></div></div>
<div class="main">
    <div class="row">
        <div class="row--small">
            <form method="POST" action="{{ route('master-class.update', $masterClass) }}">
                @csrf 
                @method('PUT')
                <h2>Редактирование мастер-класса</h2>
                <div class="form-group">
                    <label>Описание</label>
                    <textarea name="description" required>{{ old('description', $masterClass->description) }}</textarea>
                    @error('description') 
                    <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Стоимость</label>
                    <input type="number" step="0.01" name="cost" value="{{ old('cost', $masterClass->cost) }}" required>
                    @error('cost')
                    <div style="color:red; font-size:12px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <button class="btn" type="submit">Обновить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection