<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{

    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('notary_id')->unsigned()->nullable();
            $table->smallInteger('status');
            $table->string('title')->nullable();
            $table->string('cadastral_number')->nullable();
            $table->text('cadastral_number_data')->nullable();
            $table->integer('type');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('image')->nullable();

            $table->text('additional_seller_data')->nullable();
            $table->text('seller_data')->nullable();
            $table->text('additional_client_data')->nullable();
            $table->text('client_data')->nullable();
            $table->text('property_data')->nullable();
            $table->text('notary_data')->nullable();
            $table->text('mortgage_data')->nullable();
            $table->text('married_data')->nullable();
            $table->text('representative_data')->nullable();
            $table->text('co_owner_data')->nullable();
            $table->text('sign_info')->nullable();
            $table->text('notary_fees')->nullable();
            $table->text('fees')->nullable();
            $table->string('sign_info_file')->nullable();

            $table->string('document_file')->nullable();

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
