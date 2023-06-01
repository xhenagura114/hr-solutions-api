<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('departments')->delete();

        \DB::table('departments')->insert(array(
            0 =>
                array(
                    'id' => 3,
                    'parent_id' => 2,
                    'name' => 'Human Resources',
                    'color' => '#000000',
                ),
            1 =>
                array(
                    'id' => 4,
                    'parent_id' => 2,
                    'name' => 'Financa',
                    'color' => '#b2a2c7',
                ),
            2 =>
                array(
                    'id' => 5,
                    'parent_id' => 2,
                    'name' => 'Account Department',
                    'color' => '#4bacc6',
                ),
            3 =>
                array(
                    'id' => 6,
                    'parent_id' => 2,
                    'name' => 'BTL Department',
                    'color' => '#ff0000',
                ),
            4 =>
                array(
                    'id' => 7,
                    'parent_id' => 2,
                    'name' => 'Creative & Art Department',
                    'color' => '#974806',
                ),
            5 =>
                array(
                    'id' => 8,
                    'parent_id' => 2,
                    'name' => 'Media Department',
                    'color' => '#663300',
                ),
            6 =>
                array(
                    'id' => 9,
                    'parent_id' => 2,
                    'name' => 'Online Marketing Department',
                    'color' => '#0070c0',
                ),
            7 =>
                array(
                    'id' => 10,
                    'parent_id' => 2,
                    'name' => 'PR Department',
                    'color' => '#0070c0',
                ),
            8 =>
                array(
                    'id' => 11,
                    'parent_id' => 2,
                    'name' => 'Traffic & Production Department',
                    'color' => '#0070c0',
                ),
            9 =>
                array(
                    'id' => 12,
                    'parent_id' => 2,
                    'name' => 'Digital Technology Department',
                    'color' => '#92d050',
                ),
            10 =>
                array(
                    'id' => 13,
                    'parent_id' => 2,
                    'name' => 'Research',
                    'color' => '#0070c0',
                ),
            11 =>
                array(
                    'id' => 1,
                    'parent_id' => NULL,
                    'name' => 'CEO',
                    'color' => '#0070c0',
                ),
            12 =>
                array(
                    'id' => 2,
                    'parent_id' => 1,
                    'name' => 'Managing Director',
                    'color' => '#0070c0',
                ),
        ));


    }
}