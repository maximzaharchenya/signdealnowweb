<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
            0 =>
                array(
                    'name' => Str::random(10),
                    'surname' => Str::random(10),
                    'middle_name' => Str::random(10),
                    'email' => 'admin@ilavista.by',
                    'password' => Hash::make('password'),
                    'profile_image' => Str::random(10),
                    'type' => 2,
                    'phone' => null,
                    'date_of_birth' => null,
                    'personal_number' => null,
                    'country' => null,
                    'city' => null,
                    'address' => null,
                    'languages' => null,
                    'about' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            1 =>
                array(
                    'name' => 'Аркадий',
                    'surname' => 'Абрамович',
                    'middle_name' => Str::random(10),
                    'email' => 'user1@mail.ru',
                    'password' => Hash::make('Q11111qqq'),
                    'type' => 3,
                    'profile_image' => null,
                    'phone' => '+375295094828',
                    'date_of_birth' => '2000-04-01',
                    'personal_number' => '1234567',
                    'country' => 'Algeria',
                    'city' => 'Талин',
                    'address' => 'Адрес в Талине',
                    'languages' => null,
                    'about' => 'Люблю кушать пиццу!',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            2 =>
                array(
                    'name' => 'Мария',
                    'surname' => 'Маркова',
                    'middle_name' => Str::random(10),
                    'email' => 'user2@mail.ru',
                    'password' => Hash::make('Q11111qqq'),
                    'type' => 3,
                    'profile_image' => null,
                    'phone' => '+375295094828',
                    'date_of_birth' => '2000-04-01',
                    'personal_number' => '1234567',
                    'country' => 'Algeria',
                    'city' => 'Талин',
                    'address' => 'Адрес в Талине',
                    'languages' => null,
                    'about' => 'Люблю кушать пиццу!',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            3 =>
                array(
                    'name' => 'Петр',
                    'surname' => 'Павлов',
                    'middle_name' => Str::random(10),
                    'email' => 'user3@mail.ru',
                    'password' => Hash::make('Q11111qqq'),
                    'type' => 3,
                    'profile_image' => null,
                    'phone' => '+375295094828',
                    'date_of_birth' => '2000-04-01',
                    'personal_number' => '1234567',
                    'country' => 'Algeria',
                    'city' => 'Талин',
                    'address' => 'Адрес в Талине',
                    'languages' => null,
                    'about' => 'Люблю кушать пиццу!',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            4 =>
                array(
                    'name' => 'Прохор',
                    'surname' => 'Пискунов',
                    'middle_name' => Str::random(10),
                    'email' => 'notary1@mail.ru',
                    'password' => Hash::make('Q11111qqq'),
                    'type' => 3,
                    'profile_image' => null,
                    'phone' => '+375295094828',
                    'date_of_birth' => '2000-04-01',
                    'personal_number' => '1234567',
                    'country' => 'Algeria',
                    'city' => 'Талин',
                    'address' => 'Адрес в Талине',
                    'languages' => null,
                    'about' => 'Люблю кушать пиццу!',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            5 =>
                array(
                    'name' => 'Юрий',
                    'surname' => 'Юсупов',
                    'middle_name' => Str::random(10),
                    'email' => 'notary2@mail.ru',
                    'password' => Hash::make('Q11111qqq'),
                    'type' => 3,
                    'profile_image' => null,
                    'phone' => '+375295094828',
                    'date_of_birth' => '2000-04-01',
                    'personal_number' => '1234567',
                    'country' => 'Algeria',
                    'city' => 'Талин',
                    'address' => 'Адрес в Талине',
                    'languages' => null,
                    'about' => 'Люблю кушать пиццу!',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
        ));
    }
}
