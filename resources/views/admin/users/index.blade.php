@extends('layouts.app')

@section('content')
    @include('admin.partial.top-nav')
    <section id="users" class="d-flex">
        @include('admin.partial.left-nav')

        <div class="page-block">
            <div class="block-head">
                <h3>Все пользователи</h3>
            </div>
            <hr>
            <div class="block-body">
                <div class="filters row">
                    <form class="col-4 d-flex align-items-end" action="/admin/users" method="GET">
                        <div class="form-group mb-0 mr-4">
                            <label for="role">Роль</label>
                            <select class="custom-select" name="role" id="role" required>
                                <option value="0">Все пользователи</option>
                                <option value="3">Пользователь</option>
                                <option value="2">Администратор</option>
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-info" type="submit">Отфильтровать</button>
                        </div>

                    </form>
                </div>
                <div>
                    <table class="w-100 mt-4">
                        <tr>
                            <th>ID</th>
                            <th>Пользователь</th>
                            <th>Роль</th>
                            <th>Телефон</th>
                            <th>Email</th>
                            <th>Страна</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td><a href='/admin/users/{{ $user->id }}/edit'> {{ $user->surname }} {{ $user->name }}</a></td>
                                <td>{{ $user->type }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->country }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="mt-3">
                        {!!  $users->links()  !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
