<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFormsToApplicants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->string('form_path')->after('cv_path')->nullable();
            $table->text('languages')->after('italian_language')->nullable();
            $table->string('actual_company')->nullable()->nullable();;
            $table->string('actual_position')->nullable()->nullable();;
            $table->text('professional_self_evaluation')->nullable();
            $table->date('interview_date')->nullable()->nullable();;
            $table->text('technical_evaluation')->nullable();
            $table->text('soft_skills')->nullable();
            $table->string('possible_position')->nullable();
            $table->string('seniority')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn('form_path');
            $table->dropColumn('actual_company');
            $table->dropColumn('actual_position');
            $table->dropColumn('professional_self_evaluation');
            $table->dropColumn('languages');
            $table->dropColumn('interview_date');
            $table->dropColumn('technical_evaluation');
            $table->dropColumn('soft_skills');
            $table->dropColumn('possible_position');
            $table->dropColumn('seniority');
        });
    }
}
