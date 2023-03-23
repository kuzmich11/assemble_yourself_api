@extends('layouts.admin')

@section('header')Редактировать пользователя@endsection

@section('content')

    <form method="post" action="{{ route('admin.users.update', ['user' => $user]) }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="is_admin">Тип пользователя (права)</label>
            <select class="form-control @error('is_admin') is-invalid @enderror" name="is_admin" id="is_admin">
                <option value="0">Нет</option>
                <option @if($user->is_admin === true) selected @endif value="{{ true }}">Админ</option>
            </select>
        </div>

        <div class="form-group">
            <label for="is_author">Тип пользователя (авторство)</label>
            <select class="form-control @error('is_author') is-invalid @enderror" name="is_author" id="is_author">
                <option value="0">Нет</option>
                <option @if($user->is_author === true) selected @endif value="{{ true }}">Автор</option>
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
                value="{{ $user->username }}"
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
                value="{{ $user->first_name }}"
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
                value="{{ $user->last_name }}"
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
                value="{{ $user->email }}"
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
                value="{{ $user->password }}"
            >
        </div>

        <button type="submit" class="btn btn-success mb-2">Изменить</button>
    </form>
@endsection
