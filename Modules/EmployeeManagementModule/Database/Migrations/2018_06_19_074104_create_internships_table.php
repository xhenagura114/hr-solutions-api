<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internships', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->date('application_date')->nullable();
            $table->text('interests')->nullable(); // cast as array
            $table->string('institution')->nullable();
            $table->enum('education', ['Middle school', 'High school', 'Bachelor', 'Master', 'PHD'])->nullable();
            $table->string('studying_for')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internships');
    }
}
