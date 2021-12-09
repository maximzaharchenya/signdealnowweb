@extends('layouts.app')

@section('content')
    @include('admin.partial.top-nav')
    <section class="d-flex">
        @include('admin.partial.left-nav')

        <div class="page-block">
            <div class="block-head">
                <h3>Добавление пользователя</h3>
            </div>
            <hr>
            <div class="block-body">
                <form action="/admin/users/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-4 flex-column d-flex">
                            <label for="profile_image">Загрузить фото</label>
                            <input type="file" name="profile_image" id="profile_image">
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-6 d-flex flex-column">
                                    <label for="name">Имя*</label>
                                    <input type="text" id="name" name="name" required>
                                </div>
                                <div class="col-6 d-flex flex-column">
                                    <label for="surname">Фамилия*</label>
                                    <input type="text" id="surname" name="surname" required>
                                </div>
                                <div class="col-6 d-flex flex-column mt-3">
                                    <label for="date">Дата рождения</label>
                                    <input type="date" id="date" name="date">
                                </div>
                                <div class="col-6 d-flex flex-column mt-3">
                                    <label for="email">Email*</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                <div class="col-6 d-flex flex-column mt-3">
                                    <label for="type">Роль</label>
                                    <select name="type" id="type" required>
                                        <option>Не выбрано</option>
                                        <option value="1">Пользователь</option>
                                        <option value="2">Администратор</option>
                                    </select>
                                </div>
                                <div class="col-6 d-flex flex-column mt-3">
                                    <label for="phone">Телефон</label>
                                    <input type="text" id="phone" name="phone">
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
                                    <input type="text" id="country" name="country">
                                </div>
                                <div class="col-6 d-flex flex-column">
                                    <label for="city">Город</label>
                                    <input type="text" id="city" name="city">
                                </div>
                                <div class="col-12 d-flex flex-column mt-3">
                                    <label for="address">Точный адрес (улица, дом, подъезд, этаж, квартира)</label>
                                    <input type="text" id="address" name="address" placeholder="Например, ул. Толбухина, д. 58, подъезд 3, этаж 9, кв. 212">
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
                                    <input type="text" id="languages" name="languages">
                                </div>
                                <div class="col-12 d-flex flex-column mt-3">
                                    <label for="about">Персональные предпочтения</label>
                                    <input type="text" id="about" name="about">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
