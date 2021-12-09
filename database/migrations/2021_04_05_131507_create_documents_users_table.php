<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsUsersTable extends Migration
{

    public function up()
    {
        Schema::create('documents_users', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id');
            $table->integer('user_id');
            $table->smallInteger('user_role');
            $table->boolean('user_signs');
            $table->boolean('user_present');
            $table->boolean('approved')->default(0);
            $table->integer('from')->nullable();
            $table->smallInteger('sign_approved')->default(0);
            $table->smallInteger('fees_approved')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('documents_users');
    }
}
