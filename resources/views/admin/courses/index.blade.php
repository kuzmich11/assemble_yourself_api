@extends('layouts.admin')

@section('header')Курсы@endsection
@section('header_link')<a href="{{ route('admin.courses.create') }}">Добавить курс</a>@endsection

@section('content')

    <div class="table-responsive">
        <table class="table table-striped table-sm table-bordered caption-top">
            <caption>List of courses</caption>
            <thead class="table-light">
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Автор</th>
                    <th scope="col">Название</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Старт</th>
                    <th scope="col">Окончание</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Действие</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
            @forelse ($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->author->username }}</td>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->description }}</td>
                    <td>{{ $course->start_date }}</td>
                    <td>{{ $course->end_date }}</td>
                    <td>{{ $course->price }}</td>
                    <td>
                        <a href="{{ route('admin.courses.edit', ['course' => $course]) }}" style="color:blue">Изм.</a> &nbsp;
                        <a href="javascript:" class="delete" rel="{{ $course->id }}" style="color:red">Уд.</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Курсов нет</td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>

@endsection

@push('js')
    <script type="text/javascript">

        document.addEventListener('DOMContentLoaded', function() {
            let elements = document.querySelectorAll(".delete");
            elements.forEach(function(item) {
                item.addEventListener("click", function() {
                    const id = this.getAttribute('rel');
                    if(confirm(`Вы действительно хотите удалить пользователя? (#ID = ${id})`)) {
                        send(`/admin/courses/${id}`).then(() => {
                            location.reload();
                        });
                    }
                });
            });
        });

        async function send(url) {
            let response = await fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            let result = await response.json();
            return result.ok;
        }
    </script>
@endpush
