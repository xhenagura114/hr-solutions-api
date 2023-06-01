<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_departments', function (Blueprint $table) {
            $table->integer('feed_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->engine = 'InnoDB';
            $table->primary(['feed_id', 'department_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_departments');
    }
}
