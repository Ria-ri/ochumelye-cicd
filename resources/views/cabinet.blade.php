@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="row">
    <div class="hover"></div>
    <div class="row--small grid between">
        <div class="content driver-page">
            <div class="driver-page-photo">
                <img src="{{ asset('img/driver-page.png') }}">
            </div>
            <div class="driver-page-name">{{ $master->name }}</div>
            <div class="driver-page-text">
                <div class="driver-page-my">Мои мастер-классы</div>
                <table class="driver-page-table">
                    <tbody>
                        @foreach($masterClasses as $mc)
                            <tr>
                                <td>{{ $mc->date }} {{ $mc->time_slot }}</td>
                                <td>
                                    <strong>{{ $mc->title }}</strong><br>
                                    Стоимость: {{ $mc->cost }} руб.<br>
                                    <a href="{{ route('master-class.edit', $mc) }}">Редактировать описание/стоимость</a>
                                    <h4>Участники:</h4>
                                    @forelse($mc->bookings as $b)
                                        {{ $b->user->name }} ({{ $b->user->email }})<br><br>
                                    @empty
                                        Нет участников.
                                    @endforelse
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="driver-page-btn-wrapper">
                <a href="{{ route('master-class.create') }}" class="driver-page-btn btn">Добавить мастер-класс</a>
            </div>
        </div>
        <ul class="menu">
            @foreach(\App\Models\Category::all() as $cat)
                <li><a href="{{ route('category.show', $cat) }}">{{ $cat->name }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
@endsection