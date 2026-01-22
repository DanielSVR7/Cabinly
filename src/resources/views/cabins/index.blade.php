@extends('layouts.app')

@section('title', 'Домики')

@section('content')
    <div class="card" style="margin-bottom: 24px;">
        <h2 style="margin-top: 0;">Доступные домики</h2>
        <p class="meta">Выберите домик и отправьте заявку на бронирование. Мы уточним детали и подтвердим бронь.</p>
    </div>

    <div class="grid">
        @forelse ($cabins as $cabin)
            <article class="card">
                <span class="badge">Вместимость: {{ $cabin->capacity }}</span>
                <h3>{{ $cabin->name }}</h3>
                <p class="meta">{{ $cabin->location ?? 'Турбаза "Сосновый берег"' }}</p>
                <p>{{ $cabin->description ?? 'Уютный домик для отдыха на природе.' }}</p>
                <p class="price">{{ number_format($cabin->price_per_night, 0, '.', ' ') }} ₽ / ночь</p>
                <a class="button" href="{{ route('cabins.show', $cabin) }}">Посмотреть и забронировать</a>
            </article>
        @empty
            <div class="card">
                <h3>Пока нет домиков</h3>
                <p class="meta">Добавьте домики через панель администратора или сидер.</p>
            </div>
        @endforelse
    </div>
@endsection
