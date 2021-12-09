<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnauthorizedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unauthorized_users', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id');
            $table->string('pin');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->smallInteger('type')->nullable();
            $table->boolean('signs');
            $table->boolean('present');
            $table->integer('from')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unauthorized_users');
    }
}
