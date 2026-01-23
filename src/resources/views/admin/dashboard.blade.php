@extends('layouts.app')

@section('title', 'Админ-панель')

@section('content')
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                <span class="badge text-bg-success">Админ</span>
                <h2 class="mb-0 section-title">Панель администратора</h2>
            </div>
            <p class="text-muted mb-0">Управляйте домиками и заявками на бронирование.</p>
        </div>
        <form method="post" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-outline-dark" type="submit">Выйти</button>
        </form>
    </div>

    <section class="mb-5">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <h3 class="section-title mb-0">Домики</h3>
            <span class="text-muted small">Всего: {{ $cabins->count() }}</span>
        </div>
        <div class="row g-4">
            @forelse ($cabins as $cabin)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
                                <div>
                                    <h5 class="card-title mb-1">{{ $cabin->name }}</h5>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $cabin->location ?? 'Локация не указана' }}
                                    </p>
                                </div>
                                <span class="badge {{ $cabin->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                                    {{ $cabin->is_active ? 'Активен' : 'Скрыт' }}
                                </span>
                            </div>
                            <p class="text-muted small mb-3">{{ $cabin->description ?? 'Описание отсутствует.' }}</p>
                            <div class="mt-auto">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="text-muted small">
                                        <i class="bi bi-people me-1"></i>Вместимость: {{ $cabin->capacity }}
                                    </span>
                                    <span class="price-tag">{{ number_format($cabin->price_per_night, 0, '.', ' ') }} ₽ / ночь</span>
                                </div>
                                <a class="btn btn-forest w-100" href="{{ route('admin.cabins.edit', $cabin) }}">Редактировать</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border mb-0">Домики пока не добавлены.</div>
                </div>
            @endforelse
        </div>
    </section>

    <section>
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <h3 class="section-title mb-0">Бронирования</h3>
            <span class="text-muted small">Всего: {{ $bookings->count() }}</span>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @forelse ($bookings as $booking)
                    @php
                        $statusLabel = $booking->status === 'confirmed'
                            ? 'Подтверждено'
                            : ($booking->status === 'cancelled' ? 'Отменено' : 'В ожидании');
                        $statusClass = $booking->status === 'confirmed'
                            ? 'text-bg-success'
                            : ($booking->status === 'cancelled' ? 'text-bg-secondary' : 'text-bg-warning');
                        $bookingTypeLabel = $booking->booking_type === 'hourly' ? 'Почасовой' : 'Посуточный';
                        $checkInTime = $booking->check_in_time ?? ($booking->booking_type === 'hourly' ? '14:00' : '14:00');
                        $checkOutTime = $booking->check_out_time ?? ($booking->booking_type === 'hourly' ? '23:00' : '12:00');
                    @endphp
                    <div class="border rounded-4 p-3 p-lg-4 mb-3">
                        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3">
                            <div>
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                    <strong>{{ $booking->guest_name }}</strong>
                                    <span class="text-muted small">{{ $booking->guest_email }}</span>
                                </div>
                                <div class="text-muted small mb-1">
                                    <i class="bi bi-house-door me-1"></i>Домик: {{ $booking->cabin->name ?? '—' }}
                                </div>
                                <div class="text-muted small mb-1">
                                    <i class="bi bi-calendar3 me-1"></i>{{ $booking->check_in->format('d.m.Y') }} → {{ $booking->check_out->format('d.m.Y') }}
                                </div>
                                <div class="text-muted small mb-1">
                                    <i class="bi bi-receipt me-1"></i>{{ $bookingTypeLabel }} тариф
                                </div>
                                <div class="text-muted small mb-1">
                                    <i class="bi bi-clock me-1"></i>Заезд: {{ $checkInTime }}, выезд: {{ $checkOutTime }}
                                </div>
                                <div class="text-muted small mb-1">
                                    <i class="bi bi-tag me-1"></i>
                                    Тариф: {{ $booking->booking_type === 'hourly' ? 'Почасовой' : 'Посуточный' }}
                                </div>
                                @if ($booking->check_in_at || $booking->check_out_at)
                                    <div class="text-muted small mb-1">
                                        <i class="bi bi-clock me-1"></i>
                                        Заезд: {{ $booking->check_in_at ? $booking->check_in_at->format('H:i') : '—' }}
                                        · Выезд: {{ $booking->check_out_at ? $booking->check_out_at->format('H:i') : '—' }}
                                    </div>
                                @endif
                                <div class="text-muted small mb-1">
                                    <i class="bi bi-people me-1"></i>Гостей: {{ $booking->guests_count }}
                                </div>
                                @if ($booking->guest_phone)
                                    <div class="text-muted small mb-1">
                                        <i class="bi bi-telephone me-1"></i>{{ $booking->guest_phone }}
                                    </div>
                                @endif
                                @if ($booking->notes)
                                    <div class="text-muted small">
                                        <i class="bi bi-chat-left-text me-1"></i>{{ $booking->notes }}
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex flex-column align-items-start align-items-lg-end gap-2">
                                <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                @if ($booking->status !== 'cancelled')
                                    <form method="post" action="{{ route('admin.bookings.update', $booking) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Отменить бронь</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Пока нет заявок.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
