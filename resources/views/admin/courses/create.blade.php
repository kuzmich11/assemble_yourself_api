@extends('layouts.admin')

@section('header')Добавить курс@endsection

@section('content')

    <form method="post" action="{{ route('admin.courses.store') }}">
        @csrf

        <div class="form-group">
            <label for="author_id">Автор</label>
            <select class="form-control @error('author_id') is-invalid @enderror" name="author_id" id="author_id">
                <option value="0">Выберете автора</option>
                @forelse($authors as $author)
                    <option @if(old('author_id') === $author->id ) selected @endif value="{{ $author->id }}">{{ $author->username }}</option>
                @empty
                    <option><a href="{{ route('admin.users.create') }}">Добавить автора</a></option>
                @endforelse
            </select>
        </div>

        <div class="form-group">
            <label for="title">Название</label>
            <input
                type="text"
                class="form-control @error('title') is-invalid @enderror"
                id="title"
                name="title"
                placeholder="..."
                value="{{ old('title') }}"
            >
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea
                class="form-control @error('description') is-invalid @enderror"
                id="description"
                name="description"
                placeholder="..."
            >{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="start_date">Старт</label>
            <input
                type="date"
                class="form-control @error('start_date') is-invalid @enderror"
                id="start_date"
                name="start_date"
                placeholder="..."
                value="{{ old('start_date') }}"
            >
        </div>

        <div class="form-group">
            <label for="end_date">Окончание</label>
            <input
                type="date"
                class="form-control @error('end_date') is-invalid @enderror"
                id="end_date"
                name="end_date"
                placeholder="..."
                value="{{ old('end_date') }}"
            >
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <input
                type="text"
                class="form-control @error('price') is-invalid @enderror"
                id="price"
                name="price"
                placeholder="..."
                value="{{ old('price') }}"
            >
        </div>

        <button type="submit" class="btn btn-success mb-2">Сохранить</button>
    </form>
@endsection
