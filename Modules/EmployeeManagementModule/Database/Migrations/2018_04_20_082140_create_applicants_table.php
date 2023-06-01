<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->date('application_date')->nullable();

            $table->integer('job_vacancy_id')->unsigned()->nullable();
            $table->foreign('job_vacancy_id')->nullable()->references('id')->on('job_vacancies')->onDelete("cascade");
            $table->string('cv_path')->nullable();
            $table->enum('status', ['New', 'Contacted', 'Interview Done', 'Hired', 'Not Good', 'Good for the Future'])->default('New');
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
        Schema::dropIfExists('applicants');
    }
}
