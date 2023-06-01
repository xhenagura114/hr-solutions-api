<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('project_name')->nullable();
            $table->date('start_training')->nullable();
            $table->date('end_training')->nullable();
            $table->string('training_skills')->nullable();
            $table->string('project_estimation')->nullable();
            $table->enum('project_type',['Project', 'Training'])->nullable();
            $table->enum('project_company', ['Moveo Albania Technology', 'Sisal Albania', 'Landmark Premium Print', 'Landmark Communications', 'Landmark Technologies','TeachPitch'])->nullable();
            $table->tinyInteger('unlimited_project')->default(0);
            $table->date('evaluation_date')->nullable();
            $table->integer('performance_level')->nullable();
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
        Schema::dropIfExists('user_projects');
    }
}
