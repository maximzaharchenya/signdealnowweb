<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert(array(
            0 =>
                array(
                    'user_id' => null,
                    'name' => 'Laravel Personal Access Client',
                    'secret' => 'U7TK2CHMBcWXcTQUiW9ERls7F7W41QSOz4jLoxIW',
                    'provider' => null,
                    'redirect' => '/',
                    'personal_access_client' => 1,
                    'password_client' => 0,
                    'revoked' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
            1 =>
                array(
                    'user_id' => null,
                    'name' => 'Laravel Password Grant Client',
                    'secret' => 'HIep12UyzTLOzQF0v2PH3LgpDFrhxCMzHQyGJq7c',
                    'provider' => 'users',
                    'redirect' => '/',
                    'personal_access_client' => 0,
                    'password_client' => 1,
                    'revoked' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ),
        ));
    }
}
