@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="row">
    <div class="hover"></div>
    <div class="title">{{ $category->name }}</div>
    <div class="row--small grid between">
        <div class="content">
            @php
                $categoryImage = asset('img/category_' . $category->id . '.jpg');
                if (!file_exists(public_path('img/category_' . $category->id . '.jpg'))) {
                    $categoryImage = asset('img/elifant.jpg');
                }
            @endphp
            <img src="{{ $categoryImage }}" style="float:left; margin-right:20px; max-width:200px;">
            <p>{{ $category->description }}</p>
        </div>
        <ul class="menu">
            @foreach(\App\Models\Category::all() as $cat)
                <li><a href="{{ route('category.show', $cat) }}">{{ $cat->name }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="row shedule">
        <div class="row--small">
            <h2>Расписание</h2>
            <div class="drivers">
                @forelse($masterClasses as $mc)
                    <div class="driver grid">
                        <div class="driver-left grid">
                            <div class="driver-photo">
                                <img src="{{ $mc->master->avatar }}">
                            </div>
                            <div class="driver-text">
                                <div class="driver-name">{{ $mc->master->name }}</div>
                                <div class="driver-desc">{{ $mc->description }}</div>
                                <div>Стоимость: {{ $mc->cost }} руб.</div>
                                <div>Свободно мест: {{ $mc->freePlaces() }} из {{ $mc->capacity }}</div>
                            </div>
                        </div>
                        <div class="driver-right">
                            @auth
                                @if($mc->freePlaces() > 0 && !auth()->user()->bookings->contains('master_class_id', $mc->id))
                                    <a href="{{ route('booking.confirm', $mc) }}" class="driver-btn">записаться</a>
                                @elseif(auth()->user()->bookings->contains('master_class_id', $mc->id))
                                    <span style="color:white;">✓ Вы записаны</span>
                                @else
                                    <span style="color:white;">Нет мест</span>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="driver-btn">Войдите, чтобы записаться</a>
                            @endauth
                            <div class="driver-time">{{ $mc->date }} {{ $mc->time_slot }}</div>
                        </div>
                    </div>
                @empty
                    <p>Нет мастер-классов в этой категории.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection