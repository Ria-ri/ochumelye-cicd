@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="row">
    <div class="hover"></div>
    <div class="title"></div>
    <div class="row--small grid between">
        <div class="content">
            <img src="{{ asset('img/elifant.png') }}" style="float:left; margin-right:20px;">
            <p>Добро пожаловать в клуб "ОчУмелые ручки"! Здесь вы найдете увлекательные мастер-классы по различным видам творчества.</p>
            <p>Наша миссия — развивать творческие способности и дарить радость. Присоединяйтесь!</p>
        </div>
        <ul class="menu">
            @foreach($categories as $cat)
                <li><a href="{{ route('category.show', $cat) }}">{{ $cat->name }}</a></li>
            @endforeach
        </ul>
    </div>

    @auth
    <div class="row shedule" style="margin-top:30px;">
        <div class="row--small">
            <h2>Мои записи</h2>
            <div class="drivers">
                @forelse($userBookings as $booking)
                    <div class="driver grid">
                        <div class="driver-left grid">
                            <div class="driver-text">
                                <div class="driver-name">{{ $booking->masterClass->title }}</div>
                                <div class="driver-desc">{{ $booking->masterClass->description }}</div>
                                <div>Дата: {{ $booking->masterClass->date }} | Время: {{ $booking->masterClass->time_slot }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Вы пока не записаны ни на один мастер-класс.</p>
                @endforelse
            </div>
        </div>
    </div>
    @endauth
</div>
@endsection