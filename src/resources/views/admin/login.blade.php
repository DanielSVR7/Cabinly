@extends('layouts.app')

@section('title', 'Вход в админ-панель')

@section('content')
    <section class="soft-card p-4 p-lg-5 mx-auto" style="max-width: 480px;">
        <div class="text-center mb-4">
            <span class="brand-badge mb-3"><i class="bi bi-shield-lock"></i></span>
            <h2 class="section-title h4 mb-1">Админ-панель</h2>
            <p class="text-muted mb-0">Введите учетные данные администратора.</p>
        </div>

        <form method="post" action="{{ route('admin.login.store') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input id="password" name="password" type="password" class="form-control" required>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" value="1" id="remember">
                <label class="form-check-label" for="remember">Запомнить меня</label>
            </div>

            <button class="btn btn-forest w-100" type="submit">Войти</button>
        </form>
    </section>
@endsection
