<?php

use Illuminate\Database\Seeder;

class JobPositionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('job_positions')->delete();
        
        \DB::table('job_positions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => 'Senior Account Manager',
            ),
            1 =>
            array (
                'id' => 2,
                'title' => 'Junior Account Manager',
            ),
            2 =>
            array (
                'id' => 3,
                'title' => 'Account Manager',
            ),
            3 =>
            array (
                'id' => 4,
                'title' => 'BTL Manager',
            ),
            4 =>
            array (
                'id' => 5,
                'title' => 'Promotion Supervisor',
            ),
            5 =>
            array (
                'id' => 6,
                'title' => 'Promotor/Hostess',
            ),
            6 =>
            array (
                'id' => 7,
                'title' => 'Creative Director',
            ),
            7 =>
            array (
                'id' => 8,
                'title' => 'Art Director',
            ),
            8 =>
            array (
                'id' => 9,
                'title' => 'Graphic Designer',
            ),
            9 =>
            array (
                'id' => 10,
                'title' => 'Motion Graphic Designer',
            ),
            10 =>
            array (
                'id' => 11,
                'title' => 'Copywriter',
            ),
            11 =>
            array (
                'id' => 12,
                'title' => 'Media Buying Manager',
            ),
            12 =>
            array (
                'id' => 13,
                'title' => 'Online Marketing Coordinator',
            ),
            13 =>
            array (
                'id' => 14,
                'title' => 'Software Developer',
            ),
            14 =>
            array (
                'id' => 15,
                'title' => 'PR Manager',
            ),
            15 =>
            array (
                'id' => 16,
                'title' => 'Senior Trafic Manager',
            ),
            16 =>
            array (
                'id' => 17,
                'title' => 'Trafic Manager',
            ),
            17 =>
            array (
                'id' => 18,
                'title' => 'Production Manager',
            ),
            18 =>
            array (
                'id' => 19,
                'title' => 'CTO',
            ),
            19 =>
            array (
                'id' => 20,
                'title' => 'Team Leader',
            ),
            20 =>
            array (
                'id' => 21,
                'title' => 'Senior Developer',
            ),
            21 =>
            array (
                'id' => 22,
                'title' => 'Junior Developer',
            ),
            22 =>
            array (
                'id' => 23,
                'title' => 'Research Director',
            ),
            23 =>
            array (
                'id' => 24,
                'title' => 'Research Assistent',
            ),
            24 =>
            array (
                'id' => 25,
                'title' => 'Quantitative Research Expert',
            ),
            25 =>
            array (
                'id' => 26,
                'title' => 'EDB Research',
            ),
            26 =>
            array (
                'id' => 27,
                'title' => 'Research Senior',
            ),
            27 =>
            array (
                'id' => 28,
                'title' => 'Data Analyst',
            ),
            28 =>
            array (
                'id' => 29,
                'title' => 'Field Work Manager',
            ),
            29 =>
            array (
                'id' => 30,
                'title' => 'Data Entry Specialist',
            ),
            30 =>
            array (
                'id' => 31,
                'title' => 'Supervisor',
            ),
            31 =>
            array (
                'id' => 32,
                'title' => 'Field Worker',
            ),
            32 =>
            array (
                'id' => 33,
                'title' => 'Executive Director',
            ),
            33 =>
            array (
                'id' => 34,
                'title' => 'Managing Director',
            ),
            34 =>
                array (
                    'id' => 35,
                    'title' => 'CEO',
                ),
        ));
        
        
    }
}