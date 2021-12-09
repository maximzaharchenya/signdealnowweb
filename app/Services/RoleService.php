<?php

namespace App\Services;


class RoleService
{
    public function roles(): array
    {
        return array(
            '1' => 'Продавец',
            '2' => 'Покупатель',
            '3' => 'Нотариус',
            '4' => 'Юрист-консультант',
            '5' => 'Переводчик',
            '6' => 'Супруг/Супруга покупателя',
            '7' => 'Супруг/Супруга продавца',
            '8' => 'Ассистент нотариуса',
            '9' => 'Представитель банка продавца',
            '10' => 'Представитель банка покупателя',
            '11' => 'Совладелец',
            '12' => 'Представитель Юр.Лица',
            '13' => 'Другое',
        );
    }
}
