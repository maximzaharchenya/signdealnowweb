<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortgagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mortgages', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id');
            $table->integer('user_id');
            $table->string('type');
            $table->string('area')->nullable();
            $table->string('land_area')->nullable();
            $table->string('used_land_area')->nullable();
            $table->string('living_area')->nullable();
            $table->string('purpose')->nullable();
            $table->string('energy_class')->nullable();
            $table->string('city');
            $table->string('country');
            $table->string('address');
            $table->string('cadastral_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('serf_number')->nullable();
            $table->string('partnership_code')->nullable();
            $table->string('owner')->nullable();
            $table->string('owner_code')->nullable();
            $table->string('cost')->nullable();
            $table->text('holder_data')->nullable();
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
        Schema::dropIfExists('mortgages');
    }
}
