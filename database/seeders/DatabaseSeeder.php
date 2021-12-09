<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(DocumentsTableSeeder::class);
        $this->call(DocumentsUsersTableSeeder::class);
        $this->call(InputSeeder::class);
        /*$this->call(PassportSeeder::class);*/
    }
}
