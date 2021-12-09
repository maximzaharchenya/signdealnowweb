<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentsUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documents_users')->insert(array(
            0 =>
                array(
                    'document_id' => 1,
                    'user_id' => 1,
                    'user_role' => 1,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            1 =>
                array(
                    'document_id' => 2,
                    'user_id' => 2,
                    'user_role' => 1,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            2 =>
                array(
                    'document_id' => 3,
                    'user_id' => 3,
                    'user_role' => 1,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            3 =>
                array(
                    'document_id' => 4,
                    'user_id' => 3,
                    'user_role' => 2,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            4 =>
                array(
                    'document_id' => 5,
                    'user_id' => 3,
                    'user_role' => 4,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            5 =>
                array(
                    'document_id' => 6,
                    'user_id' => 3,
                    'user_role' => 2,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            6 =>
                array(
                    'document_id' => 7,
                    'user_id' => 3,
                    'user_role' => 1,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            7 =>
                array(
                    'document_id' => 8,
                    'user_id' => 3,
                    'user_role' => 4,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            8 =>
                array(
                    'document_id' => 8,
                    'user_id' => 3,
                    'user_role' => 2,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            9 =>
                array(
                    'document_id' => 9,
                    'user_id' => 3,
                    'user_role' => 11,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            10 =>
                array(
                    'document_id' => 10,
                    'user_id' => 3,
                    'user_role' => 8,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            11 =>
                array(
                    'document_id' => 11,
                    'user_id' => 3,
                    'user_role' => 5,
                    'user_signs' => 1,
                    'user_present' => 1,
                    'approved' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
        ));
    }
}
