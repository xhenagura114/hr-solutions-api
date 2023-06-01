<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsToApplicantSkills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicant_skills', function (Blueprint $table) {
            $table->integer('month_of_experience')->after('skill_id')->nullable();
            $table->integer('level')->after('month_of_experience')->nullable();
            $table->string('other_technology')->after('level')->nullable();
            $table->enum('seniority', ['Junior', 'Intermediate', 'Senior'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicant_skills', function (Blueprint $table) {
            $table->dropColumn('month_of_experience');
            $table->dropColumn('level');
            $table->dropColumn('other_technology');
            $table->dropColumn('seniority');
        });
    }
}
