<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributors', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id');
            $table->boolean('person');
            $table->smallInteger('role');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('personal_number')->nullable();
            $table->string('commercial_name')->nullable();
            $table->string('commercial_code')->nullable();
            $table->string('email')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->smallInteger('representative')->nullable();
            $table->string('representative_name')->nullable();
            $table->string('representative_surname')->nullable();
            $table->string('representative_date_of_birth')->nullable();
            $table->string('representative_email')->nullable();
            $table->string('representative_personal_number')->nullable();
            $table->string('representative_phone')->nullable();
            $table->string('representative_file')->nullable();
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
        Schema::dropIfExists('contributors');
    }
}
