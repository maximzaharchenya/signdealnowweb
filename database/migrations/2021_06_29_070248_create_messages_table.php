<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{

    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('user_name')->nullable();
            $table->string('user_image')->nullable();
            $table->text('content');
            $table->boolean('is_read')->default(false);
            $table->boolean('is_file')->default(false);
            $table->boolean('is_image')->default(false);
            $table->boolean('has_link')->default(false);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
