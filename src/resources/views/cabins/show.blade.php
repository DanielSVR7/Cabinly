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
            <div class="soft-card p-4 mb-4">
                <h3 class="section-title h5 mb-3">Календарь занятости</h3>
                <div class="calendar" data-day-statuses='@json($dayStatuses)' data-occupied-hours='@json($occupiedHours)'>
                    <div class="calendar__header">
                        <button type="button" class="btn btn-outline-secondary btn-sm calendar__prev">←</button>
                        <div class="calendar__title"></div>
                        <button type="button" class="btn btn-outline-secondary btn-sm calendar__next">→</button>
                    </div>
                    <div class="calendar__grid"></div>
                    <div class="calendar__hours"></div>
                    <div class="calendar__legend">
                        <span class="calendar__dot calendar__dot--free"></span> Свободно
                        <span class="calendar__dot calendar__dot--partial"></span> Частично занято
                        <span class="calendar__dot calendar__dot--busy"></span> Занято полностью
                    </div>
                </div>
            </div>

            <div class="soft-card p-4">
                <h3 class="section-title h5 mb-3">Бронирование</h3>
                <form method="post" action="{{ route('bookings.store', $cabin) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="booking_type" class="form-label">Тариф</label>
                        <select id="booking_type" name="booking_type" class="form-select" required>
                            <option value="daily" @selected(old('booking_type', 'daily') === 'daily')>Посуточный (заезд 14:00, выезд 12:00)</option>
                            <option value="hourly" @selected(old('booking_type') === 'hourly')>Почасовой (с 14:00 до 23:00)</option>
                        </select>
                    </div>
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
                    <div class="row g-2" data-daily-fields>
                        <div class="col-6">
                            <label for="check_in_date" class="form-label">Дата заезда</label>
                            <input id="check_in_date" name="check_in_date" type="date" class="form-control" value="{{ old('check_in_date') }}" required>
                        </div>
                        <div class="col-6">
                            <label for="check_out_date" class="form-label">Дата выезда</label>
                            <input id="check_out_date" name="check_out_date" type="date" class="form-control" value="{{ old('check_out_date') }}" required>
                        </div>
                    </div>
                    <div class="row g-2" data-hourly-fields style="display: none;">
                        <div class="col-6">
                            <label for="check_in_date_hourly" class="form-label">Дата</label>
                            <input id="check_in_date_hourly" name="check_in_date" type="date" class="form-control" value="{{ old('check_in_date') }}">
                        </div>
                        <div class="col-3">
                            <label for="check_in_time" class="form-label">Заезд</label>
                            <select id="check_in_time" name="check_in_time" class="form-select">
                                @foreach (['14:00','15:00','16:00','17:00','18:00','19:00','20:00'] as $time)
                                    <option value="{{ $time }}" @selected(old('check_in_time') === $time)>{{ $time }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="check_out_time" class="form-label">Выезд</label>
                            <select id="check_out_time" name="check_out_time" class="form-select">
                                @foreach (['17:00','18:00','19:00','20:00','21:00','22:00','23:00'] as $time)
                                    <option value="{{ $time }}" @selected(old('check_out_time') === $time)>{{ $time }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="check_out_date" id="check_out_date_hourly" value="{{ old('check_out_date') }}">
                    </div>
                    <div class="text-muted small mt-2" data-booking-hint>
                        Посуточный тариф: заезд в 14:00, выезд в 12:00 следующего дня. Почасовой тариф: 14:00–23:00, минимум 3 часа.
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

    <style>
        .calendar {
            display: grid;
            gap: 12px;
        }
        .calendar__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .calendar__title {
            font-weight: 600;
        }
        .calendar__grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
        }
        .calendar__cell {
            text-align: center;
            font-size: 0.85rem;
            padding: 6px 0;
            border-radius: 8px;
            border: 1px solid transparent;
        }
        .calendar__cell--weekday {
            font-weight: 600;
            color: #6c757d;
            padding: 4px 0;
        }
        .calendar__cell--empty {
            opacity: 0.35;
        }
        .calendar__cell--busy {
            background: rgba(220, 53, 69, 0.12);
            color: #b02a37;
            border-color: rgba(220, 53, 69, 0.2);
        }
        .calendar__cell--partial {
            background: rgba(255, 193, 7, 0.18);
            color: #a97900;
            border-color: rgba(255, 193, 7, 0.35);
        }
        .calendar__cell--today {
            border-color: #0d6efd;
        }
        .calendar__hours {
            margin-top: 8px;
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 6px;
            font-size: 0.85rem;
        }
        .calendar__hour {
            padding: 6px 8px;
            border-radius: 8px;
            border: 1px solid var(--border);
            text-align: center;
            font-size: 0.85rem;
        }
        .calendar__hour--busy {
            background: rgba(220, 53, 69, 0.12);
            color: #b02a37;
            border-color: rgba(220, 53, 69, 0.2);
        }
        .calendar__legend {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 0.85rem;
            color: #6c757d;
        }
        .calendar__dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
        .calendar__dot--free {
            background: rgba(25, 135, 84, 0.4);
        }
        .calendar__dot--partial {
            background: rgba(255, 193, 7, 0.6);
        }
        .calendar__dot--busy {
            background: rgba(220, 53, 69, 0.4);
        }
    </style>

    <script>
        (function () {
            const bookingType = document.querySelector('#booking_type');
            const dailyFields = document.querySelector('[data-daily-fields]');
            const hourlyFields = document.querySelector('[data-hourly-fields]');
            const checkInDateHourly = document.querySelector('#check_in_date_hourly');
            const checkOutDateHidden = document.querySelector('#check_out_date_hourly');

            function syncHourlyDate() {
                if (checkOutDateHidden && checkInDateHourly) {
                    checkOutDateHidden.value = checkInDateHourly.value;
                }
            }

            function toggleBookingFields() {
                if (!bookingType) {
                    return;
                }

                if (bookingType.value === 'hourly') {
                    if (dailyFields) {
                        dailyFields.style.display = 'none';
                        dailyFields.querySelectorAll('input').forEach((input) => {
                            input.required = false;
                        });
                    }
                    if (hourlyFields) {
                        hourlyFields.style.display = '';
                        hourlyFields.querySelectorAll('input, select').forEach((input) => {
                            if (input.name !== 'check_out_date') {
                                input.required = true;
                            }
                        });
                    }
                    syncHourlyDate();
                } else {
                    if (dailyFields) {
                        dailyFields.style.display = '';
                        dailyFields.querySelectorAll('input').forEach((input) => {
                            input.required = true;
                        });
                    }
                    if (hourlyFields) {
                        hourlyFields.style.display = 'none';
                        hourlyFields.querySelectorAll('input, select').forEach((input) => {
                            input.required = false;
                        });
                    }
                }
            }

            if (bookingType) {
                bookingType.addEventListener('change', toggleBookingFields);
                toggleBookingFields();
            }

            if (checkInDateHourly) {
                checkInDateHourly.addEventListener('change', syncHourlyDate);
                syncHourlyDate();
            }

            const calendar = document.querySelector('.calendar');
            if (!calendar) {
                return;
            }

            const dayStatuses = JSON.parse(calendar.dataset.dayStatuses || '{}');
            const occupiedHours = JSON.parse(calendar.dataset.occupiedHours || '{}');
            const title = calendar.querySelector('.calendar__title');
            const grid = calendar.querySelector('.calendar__grid');
            const hoursGrid = calendar.querySelector('.calendar__hours');
            const prevBtn = calendar.querySelector('.calendar__prev');
            const nextBtn = calendar.querySelector('.calendar__next');
            const weekdays = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
            const monthNames = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
            const hourSlots = ['14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00'];

            let current = new Date();
            current.setHours(0, 0, 0, 0);
            let selectedDate = null;

            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            function render() {
                grid.innerHTML = '';
                title.textContent = `${monthNames[current.getMonth()]} ${current.getFullYear()}`;

                weekdays.forEach((weekday) => {
                    const cell = document.createElement('div');
                    cell.className = 'calendar__cell calendar__cell--weekday';
                    cell.textContent = weekday;
                    grid.appendChild(cell);
                });

                const firstDay = new Date(current.getFullYear(), current.getMonth(), 1);
                const lastDay = new Date(current.getFullYear(), current.getMonth() + 1, 0);
                const offset = (firstDay.getDay() + 6) % 7;
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                for (let i = 0; i < offset; i += 1) {
                    const empty = document.createElement('div');
                    empty.className = 'calendar__cell calendar__cell--empty';
                    grid.appendChild(empty);
                }

                for (let day = 1; day <= lastDay.getDate(); day += 1) {
                    const date = new Date(current.getFullYear(), current.getMonth(), day);
                    const iso = formatDate(date);
                    const cell = document.createElement('div');
                    const status = dayStatuses[iso] || 'free';
                    const isBusy = status === 'full';
                    const isPartial = status === 'partial';

                    cell.className = `calendar__cell${isBusy ? ' calendar__cell--busy' : ''}${isPartial ? ' calendar__cell--partial' : ''}${date.getTime() === today.getTime() ? ' calendar__cell--today' : ''}`;
                    cell.textContent = String(day);
                    cell.dataset.date = iso;
                    cell.addEventListener('click', () => {
                        selectedDate = iso;
                        renderHours();
                    });
                    grid.appendChild(cell);
                }

                if (!selectedDate) {
                    selectedDate = formatDate(today);
                }
                renderHours();
            }

            function renderHours() {
                if (!hoursGrid) {
                    return;
                }

                const busy = new Set(occupiedHours[selectedDate] || []);
                hoursGrid.innerHTML = '';

                hourSlots.forEach((hour) => {
                    const cell = document.createElement('div');
                    const isBusy = busy.has(hour);
                    cell.className = `calendar__hour${isBusy ? ' calendar__hour--busy' : ''}`;
                    cell.textContent = hour;
                    hoursGrid.appendChild(cell);
                });
            }

            prevBtn.addEventListener('click', () => {
                current.setMonth(current.getMonth() - 1);
                render();
            });

            nextBtn.addEventListener('click', () => {
                current.setMonth(current.getMonth() + 1);
                render();
            });

            render();
        })();
    </script>
@endsection
