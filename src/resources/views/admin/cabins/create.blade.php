@extends('layouts.app')

@section('title', 'Добавить домик')

@section('content')
    <section class="soft-card p-4 p-lg-5 mx-auto" style="max-width: 820px;">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4">
            <div>
                <h2 class="section-title h3 mb-1">Новый домик</h2>
                <p class="text-muted mb-0">Заполните основные параметры домика для публикации.</p>
            </div>
            <span class="pill"><i class="bi bi-house-add"></i> Создание</span>
        </div>

        <form method="post" action="{{ route('admin.cabins.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-12">
                    <label for="name" class="form-label">Название</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-12">
                    <label for="location" class="form-label">Локация</label>
                    <input id="location" name="location" type="text" class="form-control" value="{{ old('location') }}">
                </div>
                <div class="col-12">
                    <label for="description" class="form-label">Описание</label>
                    <textarea id="description" name="description" rows="5" class="form-control">{{ old('description') }}</textarea>
                </div>
                <div class="col-12">
                    <label for="image" class="form-label">Фото домика</label>
                    <input id="image" name="image" type="file" class="form-control" accept="image/*">
                    <div class="form-text">JPG/PNG/WebP, до 5 МБ.</div>
                </div>
                <div class="col-md-4">
                    <label for="capacity" class="form-label">Вместимость</label>
                    <input id="capacity" name="capacity" type="number" min="1" max="20" class="form-control" value="{{ old('capacity', 1) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="max_extra_guests" class="form-label">Макс. гостей сверх нормы</label>
                    <input id="max_extra_guests" name="max_extra_guests" type="number" min="0" max="20" class="form-control" value="{{ old('max_extra_guests', 0) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="price_per_night" class="form-label">Цена за сутки</label>
                    <div class="input-group">
                        <input id="price_per_night" name="price_per_night" type="number" min="0" step="0.01" class="form-control" value="{{ old('price_per_night', 0) }}" required>
                        <span class="input-group-text">₽</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="price_per_hour" class="form-label">Цена за час</label>
                    <div class="input-group">
                        <input id="price_per_hour" name="price_per_hour" type="number" min="0" step="0.01" class="form-control" value="{{ old('price_per_hour', 0) }}" required>
                        <span class="input-group-text">₽</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="extra_guest_price_per_night" class="form-label">Доплата за гостя/сутки</label>
                    <div class="input-group">
                        <input id="extra_guest_price_per_night" name="extra_guest_price_per_night" type="number" min="0" step="0.01" class="form-control" value="{{ old('extra_guest_price_per_night', 0) }}" required>
                        <span class="input-group-text">₽</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="extra_guest_price_per_hour" class="form-label">Доплата за гостя/час</label>
                    <div class="input-group">
                        <input id="extra_guest_price_per_hour" name="extra_guest_price_per_hour" type="number" min="0" step="0.01" class="form-control" value="{{ old('extra_guest_price_per_hour', 0) }}" required>
                        <span class="input-group-text">₽</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="is_active" class="form-label">Статус</label>
                    <select id="is_active" name="is_active" class="form-select" required>
                        <option value="1" @selected(old('is_active', 1) == 1)>Активен</option>
                        <option value="0" @selected(old('is_active', 1) == 0)>Скрыт</option>
                    </select>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-4">
                <button class="btn btn-forest" type="submit">Создать</button>
                <a class="btn btn-outline-secondary" href="{{ route('admin.dashboard') }}">Назад</a>
            </div>
        </form>
    </section>
@endsection
