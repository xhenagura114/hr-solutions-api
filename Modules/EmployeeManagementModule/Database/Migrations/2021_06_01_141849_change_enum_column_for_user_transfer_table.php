<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeEnumColumnForUserTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('user_transfers', function (Blueprint $table) {
            DB::statement("ALTER TABLE user_transfers CHANGE COLUMN transfer_company transfer_company ENUM('Moveo Albania Technology', 'Sisal Albania', 'Landmark Premium Print', 'Landmark Communications', 'Landmark Technologies','TeachPitch')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
