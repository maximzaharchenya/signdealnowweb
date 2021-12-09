@extends('layouts.app')

@section('content')
    @include('admin.partial.top-nav')
    <section class="d-flex">
        @include('admin.partial.left-nav')

        <div class="page-block">
            <div class="block-head">
                <h3>Редактирование пользователя</h3>
            </div>
            <hr>
            <div class="block-body">
                <form action="/admin/users/{{ $user->id }}/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-4 flex-column d-flex">
                            @if($user->profile_image)
                            <div style="width: 200px; height: 200px">
                                <img class="w-100 h-100" src="/storage/{{ $user->profile_image }}" alt="">
                            </div>
                            @endif
                            <label for="profile_image">Загрузить фото</label>
                            <input type="file" name="profile_image" id="profile_image">
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-6 d-flex flex-column">
                                    <label for="name">Имя*</label>
                                    <input type="text" id="name" name="name" required value="{{ $user->name }}">
                                </div>
                                <div class="col-6 d-flex flex-column">
                                    <label for="surname">Фамилия*</label>
                                    <input type="text" id="surname" name="surname" required value="{{ $user->surname }}">
                                </div>
                                <div class="col-6 d-flex flex-column mt-3">
                                    <label for="date">Дата рождения</label>
                                    <input type="date" id="date" name="date" value="{{ $user->date }}">
                                </div>
                                <div class="col-6 d-flex flex-column mt-3">
                                    <label for="email">Email*</label>
                                    <input type="email" id="email" name="email" required value="{{ $user->email }}">
                                </div>
                                <div class="col-6 d-flex flex-column mt-3">
                                    <label for="type">Роль</label>
                                    <select name="type" id="type" required>
                                        <option>Не выбрано</option>
                                        <option value="1" @if($user->type == 1) selected @endif>Пользователь</option>
                                        <option value="2" @if($user->type == 2) selected @endif>Администратор</option>
                                    </select>
                                </div>
                                <div class="col-6 d-flex flex-column mt-3">
                                    <label for="phone">Телефон</label>
                                    <input type="text" id="phone" name="phone" value="{{ $user->phone }}">
                                </div>
                                <div class="col-6 d-flex flex-column mt-3">
                                    <label for="password">Пароль</label>
                                    <input type="password" id="password" name="password" min="6">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mt-5">
                        <div class="col-4">
                            <p class="font-weight-bold mb-1">Место жительства</p>
                            <p class="mb-0">В какой стране и городе проживаете и точный адрес (по желанию).</p>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-6 d-flex flex-column">
                                    <label for="country">Страна</label>
                                    <input type="text" id="country" name="country" value="{{ $user->country }}">
                                </div>
                                <div class="col-6 d-flex flex-column">
                                    <label for="city">Город</label>
                                    <input type="text" id="city" name="city" value="{{ $user->city }}">
                                </div>
                                <div class="col-12 d-flex flex-column mt-3">
                                    <label for="address">Точный адрес (улица, дом, подъезд, этаж, квартира)</label>
                                    <input type="text" id="address" name="address" placeholder="Например, ул. Толбухина, д. 58, подъезд 3, этаж 9, кв. 212" value="{{ $user->address }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mt-5">
                        <div class="col-4">
                            <p class="font-weight-bold mb-1">Дополнительно</p>
                            <p class="mb-0">Знание иностранных языков, персональные предпочтениях (по желанию).</p>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-12 d-flex flex-column">
                                    <label for="languages">Знание языков</label>
                                    <input type="text" id="languages" name="languages" value="{{ $user->languages }}">
                                </div>
                                <div class="col-12 d-flex flex-column mt-3">
                                    <label for="about">Персональные предпочтения</label>
                                    <input type="text" id="about" name="about" value="{{ $user->about }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 d-flex">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="/admin/users/{{ $user->id }}/delete" class="btn btn-danger ml-4">Удалить</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
