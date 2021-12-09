<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InputSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inputs')->insert(array(
            0 =>
                array(
                    'user_id' => 1,
                    'document_id' => 1,
                    'content' => Str::random(10),
                    'position' => 1,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            1 =>
                array(
                    'user_id' => 1,
                    'document_id' => 1,
                    'content' => Str::random(10),
                    'position' => 2,
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
        ));
    }
}
