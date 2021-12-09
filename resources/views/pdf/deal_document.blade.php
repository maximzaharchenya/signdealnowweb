<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>

<div>
    <h3>Данные продавца:</h3>
    @php($additional_seller_data = json_decode($deal->additional_seller_data))
    @if(!empty($additional_seller_data->name))<p>Имя: {{ $additional_seller_data->name }}</p>@endif
    @if(!empty($additional_seller_data->surname))<p>Фамилия: {{ $additional_seller_data->surname }}</p>@endif
    @if(!empty($additional_seller_data->number))<p>Личный код: {{ $additional_seller_data->number }}</p>@endif
    @if(!empty($additional_seller_data->country))<p>Страна: {{ $additional_seller_data->country }}</p>@endif
    @if(!empty($additional_seller_data->city))<p>Город: {{ $additional_seller_data->city }}</p>@endif
    @if(!empty($additional_seller_data->address))<p>Адрес: {{ $additional_seller_data->address }}</p>@endif
    @if(!empty($additional_seller_data->phone))<p>Телефон: {{ $additional_seller_data->phone }}</p>@endif
    @if(!empty($additional_seller_data->email))<p>Почта: {{ $additional_seller_data->email }}</p>@endif

    <h3>Данные о покупателях:</h3>
    @php($additional_client_data = json_decode($deal->additional_client_data))
    @foreach($additional_client_data as $additional_client)
        @if(!empty($additional_client->name))<p>Имя: {{ $additional_client->name }}</p>@endif
        @if(!empty($additional_client->surname))<p>Фамилия: {{ $additional_client->surname }}</p>@endif
        @if(!empty($additional_client->number))<p>Личный код: {{ $additional_client->number }}</p>@endif
        @if(!empty($additional_client->country))<p>Страна: {{ $additional_client->country }}</p>@endif
        @if(!empty($additional_client->city))<p>Город: {{ $additional_client->city }}</p>@endif
        @if(!empty($additional_client->address))<p>Адрес: {{ $additional_client->address }}</p>@endif
        @if(!empty($additional_client->phone))<p>Телефон: {{ $additional_client->phone }}</p>@endif
        @if(!empty($additional_client->email))<p>Почта: {{ $additional_client->email }}</p>@endif
        @if(!$loop->last)
            <p><br></p>
        @endif
    @endforeach

    <h3>Данные о недвижимости:</h3>
    @php($property_data = json_decode($deal->property_data))
    @if(!empty($property_data->country))<p>Страна: {{ $property_data->country }}</p>@endif
    @if(!empty($property_data->city))<p>Город: {{ $property_data->city }}</p>@endif
    @if(!empty($property_data->address))<p>Адрес: {{ $property_data->address }}</p>@endif
    @if(!empty($property_data->property_cost))<p>Стоиимость: {{ $property_data->property_cost }}</p>@endif
    @if(!empty($property_data->area))<p>Площадь: {{ $property_data->area }}</p>@endif
    @if(!empty($property_data->land_area))<p>Площадь участка: {{ $property_data->land_area }}</p>@endif
    @if(!empty($property_data->energy_class))<p>Класс: {{ $property_data->energy_class }}</p>@endif
    @if(!empty($property_data->purpose))<p>Назначение: {{ $property_data->purpose }}</p>@endif
</div>

</body>
</html>
