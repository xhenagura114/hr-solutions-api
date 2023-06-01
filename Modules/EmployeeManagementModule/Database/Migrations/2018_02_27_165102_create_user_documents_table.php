<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('category_name', array('CV', 'ID_CARD', 'CONTRACT', 'OTHER', 'LEGAL'))->default("OTHER");
            $table->string('file_name')->comment('original filename');
            $table->string('file_type')->comment('mime type');
            $table->integer('file_size')->comment('size in bytes');
            $table->string('file_path')->comment('stored path + new file name');
            $table->string('title')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_documents');
    }
}
