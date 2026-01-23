@extends('layouts.app')

@section('title', 'Домики')

@php
    $fallbackImages = [
        'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80',
        'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?auto=format&fit=crop&w=1200&q=80'
    ];
@endphp

@section('content')
    <section class="hero mb-4">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <span class="pill mb-3"><i class="bi bi-geo-alt"></i> Саратовская область · берег Волги</span>
                <h1 class="section-title display-6 mb-3">Забронировать номер</h1>
                <p class="text-muted mb-4">Лёгкое бронирование домиков и глэмпингов. Выберите даты, количество гостей и идеальный формат отдыха.</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="category-pill">Все категории</span>
                    <span class="category-pill">Глэмпинг</span>
                    <span class="category-pill">С панорамным видом</span>
                    <span class="category-pill">Семейные</span>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="soft-card p-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small text-muted">Заезд</label>
                            <input type="date" class="form-control" value="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Выезд</label>
                            <input type="date" class="form-control" value="{{ now()->addDays(2)->format('Y-m-d') }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Гости</label>
                            <select class="form-select">
                                @for ($i = 1; $i <= 6; $i++)
                                    <option>{{ $i }} гостей</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Тип</label>
                            <select class="form-select">
                                <option>Все</option>
                                <option>Домик</option>
                                <option>Глэмпинг</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-forest w-100">Найти</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4" id="features">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="soft-card p-3 h-100">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-water"></i>
                        <strong>Первая линия</strong>
                    </div>
                    <p class="text-muted mb-0">Домики у воды, приватные террасы и панорамные виды.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="soft-card p-3 h-100">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-fire"></i>
                        <strong>Все включено</strong>
                    </div>
                    <p class="text-muted mb-0">Камин, мангал, завтраки и уютные зоны отдыха.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="soft-card p-3 h-100">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-wifi"></i>
                        <strong>Связь</strong>
                    </div>
                    <p class="text-muted mb-0">Wi‑Fi, парковка, охрана и быстрый заезд 24/7.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h2 class="section-title h4 mb-1">Доступные домики</h2>
            <p class="text-muted mb-0">Выберите домик и отправьте заявку на бронирование.</p>
        </div>
        <div class="d-none d-md-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm">Сначала популярные</button>
            <button class="btn btn-outline-secondary btn-sm">Сначала выгодные</button>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($cabins as $cabin)
            @php
                $index = $loop->index % count($fallbackImages);
                $image = $fallbackImages[$index];
            @endphp
            <div class="col-md-6 col-lg-4">
                <article class="card booking-card h-100">
                    <img src="{{ $image }}" alt="{{ $cabin->name }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="pill"><i class="bi bi-people"></i> до {{ $cabin->capacity }} гостей</span>
                            <span class="text-muted small"><i class="bi bi-star-fill text-warning"></i> 4.8</span>
                        </div>
                        <h3 class="h5 mb-1">{{ $cabin->name }}</h3>
                        <p class="text-muted small mb-2">{{ $cabin->location ?? 'Турбаза "Сосновый берег"' }}</p>
                        <p class="text-muted mb-3">{{ $cabin->description ?? 'Уютный домик для отдыха на природе.' }}</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex flex-column">
                                <div class="price-tag">{{ number_format($cabin->price_per_night, 0, '.', ' ') }} ₽ <span class="text-muted small">/ ночь</span></div>
                                <div class="text-muted small">{{ number_format($cabin->price_per_hour, 0, '.', ' ') }} ₽ / час</div>
                            </div>
                            <a class="btn btn-forest" href="{{ route('cabins.show', $cabin) }}">Забронировать</a>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="soft-card p-4 text-center">
                    <h3 class="h5">Пока нет домиков</h3>
                    <p class="text-muted mb-0">Добавьте домики через панель администратора или сидер.</p>
                </div>
            </div>
        @endforelse
    </div>
@endsection
