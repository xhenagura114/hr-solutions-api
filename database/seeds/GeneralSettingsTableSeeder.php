<?php

use Illuminate\Database\Seeder;

class GeneralSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('general_settings')->delete();
        
        \DB::table('general_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'logo_path' => 'images/logo.png',
                'dark_mode' => 0,
                'theme_path' => '1',
                'system_email' => NULL,
                'created_at' => NULL,
                'updated_at' => '2018-04-13 07:39:03',
            ),
        ));
        
        
    }
}