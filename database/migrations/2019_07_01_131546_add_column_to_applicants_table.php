<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->integer('user_experiences_id')->unsigned()->nullable();
            $table->foreign('user_experiences_id')->nullable()->references('id')->on('user_experiences')->onDelete("cascade");
            $table->integer('actual_salary')->unsigned();
            $table->integer('required_salary');
            $table->date('quit_date')->nullable();
            $table->enum('italian_language', ['Not good', 'Good', 'Very good']);
            $table->text('comments');
            $table->integer('economic_offer')->unsigned();
            $table->enum('response', ['Yes', 'No']);
            $table->text('economic_comments');
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
            $table->dropColumn('user_experiences_id');
            $table->dropColumn('actual_salary');
            $table->dropColumn('required_salary');
            $table->dropColumn('quit_date');
            $table->dropColumn('italian_language');
            $table->dropColumn('comments');
            $table->dropColumn('economic_offer');
            $table->dropColumn('response');
            $table->dropColumn('economic_comments');
        });
    }
}
