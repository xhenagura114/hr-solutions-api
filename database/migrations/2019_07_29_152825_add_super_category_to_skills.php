<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSuperCategoryToSkills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->enum('mainCategory', ['Front End', 'Back End', 'Database','Mobile', 'Other Developer', 'System Administrator', 'Dev-OPS', 'Other DevOps'])->after('title');
            $table->enum('superCategory', ['developer', 'devops'])->after('mainCategory');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn('superCategory');
            $table->dropColumn('mainCategory');
        });
    }
}
