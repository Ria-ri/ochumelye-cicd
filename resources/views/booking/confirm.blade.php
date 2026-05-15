@extends('layouts.app')

@section('content')
<div class="row row--nogutter top-line"><div class="line"></div></div>
<div class="main">
    <div class="row">
        <div class="row--small">
            <h2>Подтверждение записи</h2>
            <p><strong>ФИО:</strong> {{ $user->name }}</p>
            <p><strong>Вид творчества:</strong> {{ $masterClass->category->name }}</p>
            <p><strong>Мастер:</strong> {{ $masterClass->master->name }}</p>
            <p><strong>Дата:</strong> {{ $masterClass->date }} | <strong>Время:</strong> {{ $masterClass->time_slot }}</p>
            <p><strong>Стоимость:</strong> {{ $masterClass->cost }} руб.</p>

            <form method="POST" action="{{ route('booking.store', $masterClass) }}" style="display:inline-block;">
                @csrf
                <button class="btn" type="submit">Подтвердить</button>
            </form>
            <a href="{{ route('booking.cancel', $masterClass) }}" class="btn" style="text-decoration:none;">Отмена</a>
        </div>
    </div>
</div>
@endsection