<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('profile_image')->nullable();
            $table->smallInteger('type')->unsigned()->default(1);
            $table->rememberToken();
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('personal_number')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->json('languages')->nullable();
            $table->text('about')->nullable();
            $table->text('country_registry')->nullable();
            $table->boolean('authentication')->default(false);
            $table->string('authentication_type')->nullable();
            $table->string('authentication_transaction_id')->nullable();
            $table->text('authentication_data')->nullable();
            $table->text('user_certificate')->nullable();
            $table->text('personal_code')->nullable();
            $table->text('personal_code_type')->nullable();
            $table->string('email_check')->default(1);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}
