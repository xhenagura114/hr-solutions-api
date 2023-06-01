<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    protected $seeders = [
        'departments' => DepartmentsTableSeeder::class,
        'initial' => InitialSetupTableSeeder::class,
        'users' => UsersTableSeeder::class,
        'job_positions' => JobPositionsTableSeeder::class,
        'general_settings' => GeneralSettingsTableSeeder::class
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // FOREIGN_KEY_CHECKS used on prepopullated db tables (just for testing local env)

        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($this->seeders as $table => $seeder) {
            $this->call($seeder);
//            $this->call(DepartmentsTableSeeder::class);
//            $this->call(JobPositionsTableSeeder::class);
//            $this->call(UsersTableSeeder::class);
//            $this->call(GeneralSettingsTableSeeder::class);
    }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
