<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkidTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('skid_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('type');
            $table->boolean('status')->default(false);
            $table->string('ip')->nullable();
            $table->string('code')->nullable();
            $table->text('data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skid_transactions');
    }
}
