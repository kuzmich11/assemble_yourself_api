@extends('layouts.admin')

@section('header')Пользователи@endsection
@section('header_link')<a href="{{ route('admin.users.create') }}">Добавить пользователя</a>@endsection

@section('content')

    <div class="table-responsive">
        <table class="table table-striped table-sm table-bordered caption-top">
            <caption>List of users</caption>
            <thead class="table-light">
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Админ</th>
                    <th scope="col">Автор</th>
                    <th scope="col">Никнейм</th>
                    <th scope="col">Имя Фамилия</th>
                    <th scope="col">Почта</th>
                    <th scope="col">Пароль</th>
                    <th scope="col">Дата добавления</th>
                    <th scope="col">Действие</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->is_admin === false ? 'Нет' : 'Да' }}</td>
                    <td>{{ $user->is_author === false ? 'Нет' : 'Да' }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ "$user->first_name $user->last_name" }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->password }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', ['user' => $user]) }}" style="color:blue">Изм.</a> &nbsp;
                        <a href="javascript:" class="delete" rel="{{ $user->id }}" style="color:red">Уд.</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">Пользователей нет</td>
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
                        send(`/admin/users/${id}`).then(() => {
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
