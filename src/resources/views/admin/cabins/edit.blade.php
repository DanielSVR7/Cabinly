@extends('layouts.app')

@section('title', 'Редактировать домик')

@section('content')
    <div class="card" style="max-width: 720px; margin: 0 auto;">
        <h2 style="margin-top: 0;">Редактирование домика</h2>
        <p class="meta">Обновите информацию о домике и его доступность.</p>

        <form method="post" action="{{ route('admin.cabins.update', $cabin) }}">
            @csrf
            @method('PUT')

            <label for="name">Название</label>
            <input id="name" name="name" type="text" value="{{ old('name', $cabin->name) }}" required>

            <label for="location">Локация</label>
            <input id="location" name="location" type="text" value="{{ old('location', $cabin->location) }}">

            <label for="description">Описание</label>
            <textarea id="description" name="description" rows="5">{{ old('description', $cabin->description) }}</textarea>

            <label for="capacity">Вместимость</label>
            <input id="capacity" name="capacity" type="number" min="1" max="20" value="{{ old('capacity', $cabin->capacity) }}" required>

            <label for="price_per_night">Цена за сутки</label>
            <input id="price_per_night" name="price_per_night" type="number" min="0" step="0.01" value="{{ old('price_per_night', $cabin->price_per_night) }}" required>

            <label for="price_per_hour">Цена за час</label>
            <input id="price_per_hour" name="price_per_hour" type="number" min="0" step="0.01" value="{{ old('price_per_hour', $cabin->price_per_hour) }}" required>

            <label for="is_active">Статус</label>
            <select id="is_active" name="is_active" required>
                <option value="1" @selected(old('is_active', $cabin->is_active) == 1)>Активен</option>
                <option value="0" @selected(old('is_active', $cabin->is_active) == 0)>Скрыт</option>
            </select>

            <div style="margin-top: 16px; display: flex; gap: 8px;">
                <button class="button" type="submit">Сохранить</button>
                <a class="button" style="background: #9ca3af;" href="{{ route('admin.dashboard') }}">Назад</a>
            </div>
        </form>
    </div>
@endsection
