@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
{{--                                    <input type="text" id="languages" name="languages">--}}
                                    <select name="languages[]" id="languages" multiple class="js-example-basic-single" >
                                        <option value="Русский" >Русский</option>
                                        <option value="Английский" >Английский</option>
                                        <option value="Эстонский" >Эстонский</option>
                                        <option value="Украинский" >Украинский</option>
                                        <option value="Азербайджанский">Азербайджанский</option>
                                        <option value="Албанский">Албанский</option>
                                        <option value="Амхарский">Амхарский</option>
                                        <option value="Арабский">Арабский</option>
                                        <option value="Армянский">Армянский</option>
                                        <option value="Африкаанс">Африкаанс</option>
                                        <option value="Баскский">Баскский</option>
                                        <option value="Белорусский">Белорусский</option>
                                        <option value="Бенгальский">Бенгальский</option>
                                        <option value="Бирманский">Бирманский</option>
                                        <option value="Болгарский">Болгарский</option>
                                        <option value="Боснийский">Боснийский</option>
                                        <option value="Валлийский">Валлийский</option>
                                        <option value="Венгерский">Венгерский</option>
                                        <option value="Вьетнамский">Вьетнамский</option>
                                        <option value="Гавайский">Гавайский</option>
                                        <option value="Галисийский">Галисийский</option>
                                        <option value="Греческий">Греческий</option>
                                        <option value="Грузинский">Грузинский</option>
                                        <option value="Гуджарати">Гуджарати</option>
                                        <option value="Датский">Датский</option>
                                        <option value="Зулу">Зулу</option>
                                        <option value="Иврит">Иврит</option>
                                        <option value="Игбо">Игбо</option>
                                        <option value="Идиш">Идиш</option>
                                        <option value="Индонезийский">Индонезийский</option>
                                        <option value="Ирландский">Ирландский</option>
                                        <option value="Исландский">Исландский</option>
                                        <option value="Испанский">Испанский</option>
                                        <option value="Итальянский">Итальянский</option>
                                        <option value="Йоруба">Йоруба</option>
                                        <option value="Казахский">Казахский</option>
                                        <option value="Каннада">Каннада</option>
                                        <option value="Каталанский">Каталанский</option>
                                        <option value="Киргизский">Киргизский</option>
                                        <option value="Китайский">Китайский</option>
                                        <option value="Корейский">Корейский</option>
                                        <option value="Корсиканский">Корсиканский</option>
                                        <option value="Креольский (Гаити)">Креольский (Гаити)</option>
                                        <option value="Курманджи">Курманджи</option>
                                        <option value="Кхмерский">Кхмерский</option>
                                        <option value="Кхоса">Кхоса</option>
                                        <option value="Лаосский">Лаосский</option>
                                        <option value="Латинский">Латинский</option>
                                        <option value="Латышский">Латышский</option>
                                        <option value="Литовский">Литовский</option>
                                        <option value="Люксембургский">Люксембургский</option>
                                        <option value="Македонский">Македонский</option>
                                        <option value="Малагасийский">Малагасийский</option>
                                        <option value="Малайский">Малайский</option>
                                        <option value="Малаялам">Малаялам</option>
                                        <option value="Мальтийский">Мальтийский</option>
                                        <option value="Маори">Маори</option>
                                        <option value="Маратхи">Маратхи</option>
                                        <option value="Монгольский">Монгольский</option>
                                        <option value="Немецкий">Немецкий</option>
                                        <option value="Непальский">Непальский</option>
                                        <option value="Нидерландский">Нидерландский</option>
                                        <option value="Норвежский">Норвежский</option>
                                        <option value="Ория">Ория</option>
                                        <option value="Панджаби">Панджаби</option>
                                        <option value="Персидский">Персидский</option>
                                        <option value="Польский">Польский</option>
                                        <option value="Португальский">Португальский</option>
                                        <option value="Пушту">Пушту</option>
                                        <option value="Руанда">Руанда</option>
                                        <option value="Румынский">Румынский</option>
                                        <option value="Самоанский">Самоанский</option>
                                        <option value="Себуанский">Себуанский</option>
                                        <option value="Сербский">Сербский</option>
                                    </select>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
