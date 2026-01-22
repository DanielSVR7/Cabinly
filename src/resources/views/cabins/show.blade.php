@extends('layouts.app')

@section('title', $cabin->name)

@section('content')
    <div class="grid">
        <div class="card">
            <span class="badge">Вместимость: {{ $cabin->capacity }}</span>
            <h2>{{ $cabin->name }}</h2>
            <p class="meta">{{ $cabin->location ?? 'Турбаза "Сосновый берег"' }}</p>
            <p>{{ $cabin->description ?? 'Описание пока не заполнено.' }}</p>
            <p class="price">{{ number_format($cabin->price_per_night, 0, '.', ' ') }} ₽ / ночь</p>
        </div>

        <div class="card">
            <h3 style="margin-top: 0;">Заявка на бронирование</h3>
            <form method="post" action="{{ route('bookings.store', $cabin) }}">
                @csrf
                <label for="guest_name">Имя и фамилия</label>
                <input id="guest_name" name="guest_name" type="text" value="{{ old('guest_name') }}" required>

                <label for="guest_email">Email</label>
                <input id="guest_email" name="guest_email" type="email" value="{{ old('guest_email') }}" required>

                <label for="guest_phone">Телефон</label>
                <input id="guest_phone" name="guest_phone" type="text" value="{{ old('guest_phone') }}">

                <label for="check_in">Дата заезда</label>
                <input id="check_in" name="check_in" type="date" value="{{ old('check_in') }}" required>

                <label for="check_out">Дата выезда</label>
                <input id="check_out" name="check_out" type="date" value="{{ old('check_out') }}" required>

                <label for="guests_count">Количество гостей</label>
                <select id="guests_count" name="guests_count" required>
                    @for ($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" @selected(old('guests_count', 1) == $i)>{{ $i }}</option>
                    @endfor
                </select>

                <label for="notes">Пожелания</label>
                <textarea id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>

                <div style="margin-top: 16px;">
                    <button class="button" type="submit">Отправить заявку</button>
                </div>
            </form>
        </div>
    </div>
@endsection
