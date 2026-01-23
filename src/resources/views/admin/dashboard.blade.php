@extends('layouts.app')

@section('title', 'Админ-панель')

@section('content')
    <div class="card" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; gap: 16px;">
        <div>
            <h2 style="margin-top: 0;">Панель администратора</h2>
            <p class="meta">Управляйте домиками и заявками на бронирование.</p>
        </div>
        <form method="post" action="{{ route('admin.logout') }}">
            @csrf
            <button class="button" type="submit">Выйти</button>
        </form>
    </div>

    <div class="grid" style="margin-bottom: 24px;">
        @foreach ($cabins as $cabin)
            <div class="card">
                <h3>{{ $cabin->name }}</h3>
                <p class="meta">{{ $cabin->location ?? 'Локация не указана' }}</p>
                <p>{{ $cabin->description ?? 'Описание отсутствует.' }}</p>
                <p class="meta">Вместимость: {{ $cabin->capacity }} | {{ $cabin->is_active ? 'Активен' : 'Скрыт' }}</p>
                <p class="price">{{ number_format($cabin->price_per_night, 0, '.', ' ') }} ₽ / ночь</p>
                <a class="button" href="{{ route('admin.cabins.edit', $cabin) }}">Редактировать</a>
            </div>
        @endforeach
    </div>

    <div class="card">
        <h3 style="margin-top: 0;">Бронирования</h3>
        <div style="display: grid; gap: 12px;">
            @forelse ($bookings as $booking)
                <div style="border: 1px solid var(--border); padding: 12px; border-radius: 12px;">
                    <strong>{{ $booking->guest_name }}</strong>
                    <span class="meta">({{ $booking->guest_email }})</span>
                    <div class="meta">Домик: {{ $booking->cabin->name ?? '—' }}</div>
                    <div class="meta">{{ $booking->check_in->format('d.m.Y') }} → {{ $booking->check_out->format('d.m.Y') }} | Гостей: {{ $booking->guests_count }}</div>
                    <div class="meta">Статус: {{ $booking->status === 'confirmed' ? 'Подтверждено' : ($booking->status === 'cancelled' ? 'Отменено' : 'В ожидании') }}</div>
                    @if ($booking->guest_phone)
                        <div class="meta">Телефон: {{ $booking->guest_phone }}</div>
                    @endif
                    @if ($booking->notes)
                        <div class="meta">Пожелания: {{ $booking->notes }}</div>
                    @endif
                    @if ($booking->status !== 'cancelled')
                        <form method="post" action="{{ route('admin.bookings.update', $booking) }}" style="margin-top: 8px; display: inline-flex; gap: 8px; align-items: center;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button class="button" type="submit">Отменить бронь</button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="meta">Пока нет заявок.</p>
            @endforelse
        </div>
    </div>
@endsection
