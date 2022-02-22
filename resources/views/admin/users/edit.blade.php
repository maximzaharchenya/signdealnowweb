@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                                <img class="w-100 h-100" src="/{{ $user->profile_image }}" alt="">
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
{{--                                    <input type="text" id="languages" name="languages" value="{{ $user->languages }}">--}}
                                    <select name="languages[]" id="languages" multiple class="js-example-basic-single" >
                                        <option value="Русский" @if($user->languages and in_array('Русский',json_decode($user->languages)))selected @endif>Русский</option>
                                        <option value="Английский" @if($user->languages and in_array('Английский',json_decode($user->languages)))selected @endif>Английский</option>
                                        <option value="Эстонский" @if($user->languages and in_array('Эстонский',json_decode($user->languages)))selected @endif>Эстонский</option>
                                        <option value="Украинский" @if($user->languages and in_array('Украинский',json_decode($user->languages)))selected @endif>Украинский</option>
                                        <option value="Азербайджанский" @if($user->languages and in_array('Азербайджанский',json_decode($user->languages)))selected @endif>Азербайджанский</option>
                                        <option value="Албанский" @if($user->languages and in_array('Албанский',json_decode($user->languages)))selected @endif>Албанский</option>
                                        <option value="Амхарский" @if($user->languages and in_array('Амхарский',json_decode($user->languages)))selected @endif>Амхарский</option>
                                        <option value="Арабский" @if($user->languages and in_array('Арабский',json_decode($user->languages)))selected @endif>Арабский</option>
                                        <option value="Армянский" @if($user->languages and in_array('Армянский',json_decode($user->languages)))selected @endif>Армянский</option>
                                        <option value="Африкаанс" @if($user->languages and in_array('Африкаанс',json_decode($user->languages)))selected @endif>Африкаанс</option>
                                        <option value="Баскский" @if($user->languages and in_array('Баскский',json_decode($user->languages)))selected @endif>Баскский</option>
                                        <option value="Белорусский" @if($user->languages and in_array('Белорусский',json_decode($user->languages)))selected @endif>Белорусский</option>
                                        <option value="Бенгальский" @if($user->languages and in_array('Бенгальский',json_decode($user->languages)))selected @endif>Бенгальский</option>
                                        <option value="Бирманский" @if($user->languages and in_array('Бирманский',json_decode($user->languages)))selected @endif>Бирманский</option>
                                        <option value="Болгарский" @if($user->languages and in_array('Болгарский',json_decode($user->languages)))selected @endif>Болгарский</option>
                                        <option value="Боснийский" @if($user->languages and in_array('Боснийский',json_decode($user->languages)))selected @endif>Боснийский</option>
                                        <option value="Валлийский" @if($user->languages and in_array('Валлийский',json_decode($user->languages)))selected @endif>Валлийский</option>
                                        <option value="Венгерский" @if($user->languages and in_array('Венгерский',json_decode($user->languages)))selected @endif>Венгерский</option>
                                        <option value="Вьетнамский" @if($user->languages and in_array('Вьетнамский',json_decode($user->languages)))selected @endif>Вьетнамский</option>
                                        <option value="Гавайский" @if($user->languages and in_array('Гавайский',json_decode($user->languages)))selected @endif>Гавайский</option>
                                        <option value="Галисийский" @if($user->languages and in_array('Галисийский',json_decode($user->languages)))selected @endif>Галисийский</option>
                                        <option value="Греческий" @if($user->languages and in_array('Греческий',json_decode($user->languages)))selected @endif>Греческий</option>
                                        <option value="Грузинский" @if($user->languages and in_array('Грузинский',json_decode($user->languages)))selected @endif>Грузинский</option>
                                        <option value="Гуджарати" @if($user->languages and in_array('Гуджарати',json_decode($user->languages)))selected @endif>Гуджарати</option>
                                        <option value="Датский" @if($user->languages and in_array('Датский',json_decode($user->languages)))selected @endif>Датский</option>
                                        <option value="Зулу" @if($user->languages and in_array('Зулу',json_decode($user->languages)))selected @endif>Зулу</option>
                                        <option value="Иврит" @if($user->languages and in_array('Иврит',json_decode($user->languages)))selected @endif>Иврит</option>
                                        <option value="Игбо" @if($user->languages and in_array('Игбо',json_decode($user->languages)))selected @endif>Игбо</option>
                                        <option value="Идиш" @if($user->languages and in_array('Идиш',json_decode($user->languages)))selected @endif>Идиш</option>
                                        <option value="Индонезийский" @if($user->languages and in_array('Индонезийский',json_decode($user->languages)))selected @endif>Индонезийский</option>
                                        <option value="Ирландский" @if($user->languages and in_array('Ирландский',json_decode($user->languages)))selected @endif>Ирландский</option>
                                        <option value="Исландский" @if($user->languages and in_array('Исландский',json_decode($user->languages)))selected @endif>Исландский</option>
                                        <option value="Испанский" @if($user->languages and in_array('Испанский',json_decode($user->languages)))selected @endif>Испанский</option>
                                        <option value="Итальянский" @if($user->languages and in_array('Итальянский',json_decode($user->languages)))selected @endif>Итальянский</option>
                                        <option value="Йоруба" @if($user->languages and in_array('Йоруба',json_decode($user->languages)))selected @endif>Йоруба</option>
                                        <option value="Казахский" @if($user->languages and in_array('Казахский',json_decode($user->languages)))selected @endif>Казахский</option>
                                        <option value="Каннада" @if($user->languages and in_array('Каннада',json_decode($user->languages)))selected @endif>Каннада</option>
                                        <option value="Каталанский" @if($user->languages and in_array('Каталанский',json_decode($user->languages)))selected @endif>Каталанский</option>
                                        <option value="Киргизский" @if($user->languages and in_array('Киргизский',json_decode($user->languages)))selected @endif>Киргизский</option>
                                        <option value="Китайский" @if($user->languages and in_array('Китайский',json_decode($user->languages)))selected @endif>Китайский</option>
                                        <option value="Корейский" @if($user->languages and in_array('Корейский',json_decode($user->languages)))selected @endif>Корейский</option>
                                        <option value="Корсиканский" @if($user->languages and in_array('Корсиканский',json_decode($user->languages)))selected @endif>Корсиканский</option>
                                        <option value="Креольский (Гаити)" @if($user->languages and in_array('Креольский (Гаити)',json_decode($user->languages)))selected @endif>Креольский (Гаити)</option>
                                        <option value="Курманджи" @if($user->languages and in_array('Курманджи',json_decode($user->languages)))selected @endif>Курманджи</option>
                                        <option value="Кхмерский" @if($user->languages and in_array('Кхмерский',json_decode($user->languages)))selected @endif>Кхмерский</option>
                                        <option value="Кхоса" @if($user->languages and in_array('Кхоса',json_decode($user->languages)))selected @endif>Кхоса</option>
                                        <option value="Лаосский" @if($user->languages and in_array('Лаосский',json_decode($user->languages)))selected @endif>Лаосский</option>
                                        <option value="Латинский" @if($user->languages and in_array('Латинский',json_decode($user->languages)))selected @endif>Латинский</option>
                                        <option value="Латышский" @if($user->languages and in_array('Латышский',json_decode($user->languages)))selected @endif>Латышский</option>
                                        <option value="Литовский" @if($user->languages and in_array('Литовский',json_decode($user->languages)))selected @endif>Литовский</option>
                                        <option value="Люксембургский" @if($user->languages and in_array('Люксембургский',json_decode($user->languages)))selected @endif>Люксембургский</option>
                                        <option value="Македонский" @if($user->languages and in_array('Македонский',json_decode($user->languages)))selected @endif>Македонский</option>
                                        <option value="Малагасийский" @if($user->languages and in_array('Малагасийский',json_decode($user->languages)))selected @endif>Малагасийский</option>
                                        <option value="Малайский" @if($user->languages and in_array('Малайский',json_decode($user->languages)))selected @endif>Малайский</option>
                                        <option value="Малаялам" @if($user->languages and in_array('Малаялам',json_decode($user->languages)))selected @endif>Малаялам</option>
                                        <option value="Мальтийский" @if($user->languages and in_array('Мальтийский',json_decode($user->languages)))selected @endif>Мальтийский</option>
                                        <option value="Маори" @if($user->languages and in_array('Маори',json_decode($user->languages)))selected @endif>Маори</option>
                                        <option value="Маратхи" @if($user->languages and in_array('Маратхи',json_decode($user->languages)))selected @endif>Маратхи</option>
                                        <option value="Монгольский" @if($user->languages and in_array('Монгольский',json_decode($user->languages)))selected @endif>Монгольский</option>
                                        <option value="Немецкий" @if($user->languages and in_array('Немецкий',json_decode($user->languages)))selected @endif>Немецкий</option>
                                        <option value="Непальский" @if($user->languages and in_array('Непальский',json_decode($user->languages)))selected @endif>Непальский</option>
                                        <option value="Нидерландский" @if($user->languages and in_array('Нидерландский',json_decode($user->languages)))selected @endif>Нидерландский</option>
                                        <option value="Норвежский" @if($user->languages and in_array('Норвежский',json_decode($user->languages)))selected @endif>Норвежский</option>
                                        <option value="Ория" @if($user->languages and in_array('Ория',json_decode($user->languages)))selected @endif>Ория</option>
                                        <option value="Панджаби" @if($user->languages and in_array('Панджаби',json_decode($user->languages)))selected @endif>Панджаби</option>
                                        <option value="Персидский" @if($user->languages and in_array('Персидский',json_decode($user->languages)))selected @endif>Персидский</option>
                                        <option value="Польский" @if($user->languages and in_array('Польский',json_decode($user->languages)))selected @endif>Польский</option>
                                        <option value="Португальский" @if($user->languages and in_array('Португальский',json_decode($user->languages)))selected @endif>Португальский</option>
                                        <option value="Пушту" @if($user->languages and in_array('Пушту',json_decode($user->languages)))selected @endif>Пушту</option>
                                        <option value="Руанда" @if($user->languages and in_array('Руанда',json_decode($user->languages)))selected @endif>Руанда</option>
                                        <option value="Румынский" @if($user->languages and in_array('Румынский',json_decode($user->languages)))selected @endif>Румынский</option>
                                        <option value="Самоанский" @if($user->languages and in_array('Самоанский',json_decode($user->languages)))selected @endif>Самоанский</option>
                                        <option value="Себуанский" @if($user->languages and in_array('Себуанский',json_decode($user->languages)))selected @endif>Себуанский</option>
                                        <option value="Сербский" @if($user->languages and in_array('Сербский',json_decode($user->languages)))selected @endif>Сербский</option>
                                    </select>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
