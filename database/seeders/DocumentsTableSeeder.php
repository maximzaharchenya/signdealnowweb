<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documents')->insert(array(
            0 =>
                array(
                    'status' => 1,
                    'title' => Str::random(10) . '.docx',
                    'type' => 1,
                    'country' => 'Algeria',
                    'city' => Str::random(10),
                    'address' => Str::random(10),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            1 =>
                array(
                    'status' => 1,
                    'title' => Str::random(10) . '.docx',
                    'type' => 1,
                    'country' => 'Algeria',
                    'city' => Str::random(10),
                    'address' => Str::random(10),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            2 =>
                array(
                    'status' => 2,
                    'title' => Str::random(10) . '.docx',
                    'type' => 2,
                    'country' => 'Algeria',
                    'city' => Str::random(10),
                    'address' => Str::random(10),
                    'created_at' => new Carbon('2016-01-23'),
                    'updated_at' => Carbon::now()
                ),
            3 =>
                array(
                    'status' => 3,
                    'title' => Str::random(10) . '.docx',
                    'type' => 1,
                    'country' => 'Algeria',
                    'city' => Str::random(10),
                    'address' => Str::random(10),
                    'created_at' => new Carbon('2016-01-25'),
                    'updated_at' => Carbon::now()
                ),
            4 =>
                array(
                    'status' => 1,
                    'title' => Str::random(10) . '.docx',
                    'type' => 1,
                    'country' => 'Algeria',
                    'city' => Str::random(10),
                    'address' => Str::random(10),
                    'created_at' => new Carbon('2016-01-26'),
                    'updated_at' => Carbon::now()
                ),
            5 =>
                array(
                    'status' => 4,
                    'title' => Str::random(10) . '.docx',
                    'type' => 2,
                    'country' => 'Algeria',
                    'city' => Str::random(10),
                    'address' => Str::random(10),
                    'created_at' => new Carbon('2016-01-27'),
                    'updated_at' => Carbon::now()
                ),
            6 =>
                array(
                    'status' => 1,
                    'title' => Str::random(10) . '.docx',
                    'type' => 2,
                    'country' => 'Algeria',
                    'city' => Str::random(10),
                    'address' => Str::random(10),
                    'created_at' => new Carbon('2016-01-28'),
                    'updated_at' => Carbon::now()
                ),
            7 =>
                array(
                    'status' => 1,
                    'title' => Str::random(10) . '.docx',
                    'type' => 2,
                    'country' => 'Algeria',
                    'city' => Str::random(10),
                    'address' => Str::random(10),
                    'created_at' => new Carbon('2019-02-01'),
                    'updated_at' => Carbon::now()
                ),
            8 =>
                array(
                    'status' => 3,
                    'title' => Str::random(10) . '.docx',
                    'type' => 2,
                    'country' => 'Algeria',
                    'city' => Str::random(10),
                    'address' => Str::random(10),
                    'created_at' => new Carbon('2019-02-02'),
                    'updated_at' => Carbon::now()
                ),
            9 =>
                array(
                    'status' => 2,
                    'title' => Str::random(10) . '.docx',
                    'type' => 1,
                    'country' => 'Algeria',
                    'city' => Str::random(10),
                    'address' => Str::random(10),
                    'created_at' => new Carbon('2019-02-03'),
                    'updated_at' => Carbon::now()
                ),
            10 =>
                array(
                    'status' => 5,
                    'title' => Str::random(10) . '.docx',
                    'type' => 1,
                    'country' => 'Algeria',
                    'city' => Str::random(10),
                    'address' => Str::random(10),
                    'created_at' => new Carbon('2019-02-04'),
                    'updated_at' => Carbon::now()
                ),
        ));
    }
}
