@extends('layouts.app')

@section('title', $cabin->name)

@php
    $detailImage = 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1600&q=80';
@endphp

@section('content')
    <div class="row g-4 align-items-start">
        <div class="col-lg-7">
            <div class="soft-card overflow-hidden mb-4">
                <img src="{{ $detailImage }}" class="w-100" style="max-height: 340px; object-fit: cover;" alt="{{ $cabin->name }}">
                <div class="p-4">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="pill"><i class="bi bi-people"></i> до {{ $cabin->capacity }} гостей</span>
                        <span class="pill"><i class="bi bi-geo-alt"></i> {{ $cabin->location ?? 'Сосновый берег' }}</span>
                    </div>
                    <h2 class="section-title h3 mb-2">{{ $cabin->name }}</h2>
                    <p class="text-muted mb-3">{{ $cabin->description ?? 'Описание пока не заполнено.' }}</p>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-fire"></i>
                            <span class="text-muted">Камин и зона отдыха</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-cup-hot"></i>
                            <span class="text-muted">Завтрак включен</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-tree"></i>
                            <span class="text-muted">Приватная терраса</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4">
                        <div class="price-tag">{{ number_format($cabin->price_per_night, 0, '.', ' ') }} ₽ <span class="text-muted small">/ ночь</span></div>
                        <span class="text-muted small"><i class="bi bi-star-fill text-warning"></i> 4.8 · 120 отзывов</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="soft-card p-4">
                <h3 class="section-title h5 mb-3">Бронирование</h3>
                <form method="post" action="{{ route('bookings.store', $cabin) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="guest_name" class="form-label">Имя и фамилия</label>
                        <input id="guest_name" name="guest_name" type="text" class="form-control" value="{{ old('guest_name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="guest_email" class="form-label">Email</label>
                        <input id="guest_email" name="guest_email" type="email" class="form-control" value="{{ old('guest_email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="guest_phone" class="form-label">Телефон</label>
                        <input id="guest_phone" name="guest_phone" type="text" class="form-control" value="{{ old('guest_phone') }}">
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label for="check_in" class="form-label">Дата заезда</label>
                            <input id="check_in" name="check_in" type="date" class="form-control" value="{{ old('check_in') }}" required>
                        </div>
                        <div class="col-6">
                            <label for="check_out" class="form-label">Дата выезда</label>
                            <input id="check_out" name="check_out" type="date" class="form-control" value="{{ old('check_out') }}" required>
                        </div>
                    </div>
                    <div class="mb-3 mt-2">
                        <label for="guests_count" class="form-label">Количество гостей</label>
                        <select id="guests_count" name="guests_count" class="form-select" required>
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" @selected(old('guests_count', 1) == $i)>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Пожелания</label>
                        <textarea id="notes" name="notes" rows="4" class="form-control">{{ old('notes') }}</textarea>
                    </div>
                    <button class="btn btn-forest w-100" type="submit">Забронировать</button>
                    <p class="text-muted small mt-2 mb-0">Бронирование подтверждается автоматически.</p>
                </form>
            </div>
        </div>
    </div>
@endsection
