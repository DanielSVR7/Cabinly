@extends('layouts.app')

@section('title', 'Вход в админ-панель')

@section('content')
    <div class="card" style="max-width: 420px; margin: 0 auto;">
        <h2 style="margin-top: 0;">Админ-панель</h2>
        <p class="meta">Введите учетные данные администратора.</p>

        <form method="post" action="{{ route('admin.login.store') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>

            <label for="password">Пароль</label>
            <input id="password" name="password" type="password" required>

            <label style="display: inline-flex; align-items: center; gap: 8px; margin-top: 16px; font-weight: normal;">
                <input type="checkbox" name="remember" value="1">
                Запомнить меня
            </label>

            <div style="margin-top: 16px;">
                <button class="button" type="submit">Войти</button>
            </div>
        </form>
    </div>
@endsection
