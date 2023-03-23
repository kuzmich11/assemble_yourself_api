@extends('layouts.admin')

@section('header')Добавить пользователя@endsection

@section('content')

    <form method="post" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="form-group">
            <label for="is_admin">Тип пользователя (права)</label>
            <select class="form-control @error('is_admin') is-invalid @enderror" name="is_admin" id="is_admin">
                <option value="0">Нет</option>
                <option @if(old('is_admin') === true) selected @endif value="{{ true }}">Админ</option>
            </select>
        </div>

        <div class="form-group">
            <label for="is_author">Тип пользователя (авторство)</label>
            <select class="form-control @error('is_author') is-invalid @enderror" name="is_author" id="is_author">
                <option value="0">Нет</option>
                <option @if(old('is_author') === true) selected @endif value="{{ true }}">Автор</option>
            </select>
        </div>

        <div class="form-group">
            <label for="username">Никнейм</label>
            <input
                type="text"
                class="form-control @error('username') is-invalid @enderror"
                id="username"
                name="username"
                placeholder="..."
                value="{{ old('username') }}"
            >
        </div>

        <div class="form-group">
            <label for="first_name">Имя</label>
            <input
                type="text"
                class="form-control @error('first_name') is-invalid @enderror"
                id="first_name"
                name="first_name"
                placeholder="..."
                value="{{ old('first_name') }}"
            >
        </div>

        <div class="form-group">
            <label for="last_name">Фамилия</label>
            <input
                type="text"
                class="form-control @error('last_name') is-invalid @enderror"
                id="last_name"
                name="last_name"
                placeholder="..."
                value="{{ old('last_name') }}"
            >
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                placeholder="..."
                value="{{ old('email') }}"
            >
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                id="password"
                name="password"
                placeholder="..."
                value="{{ old('password') }}"
            >
        </div>

        <button type="submit" class="btn btn-success mb-2">Сохранить</button>
    </form>
@endsection
