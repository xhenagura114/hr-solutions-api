<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('department_id')->unsigned()->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->enum('reason', array('VACATION', 'PERSONAL', 'SICK'));
            $table->string('description')->nullable();//optional
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', array('PENDING', 'APPROVED', 'REJECTED'));// default is the first value "PENDING"
            $table->string('reject_reason')->nullable();//optional
            $table->text('approvers')->nullable(); // cast as array
            $table->string('photo_path');
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
        Schema::dropIfExists('requests');
    }
}
