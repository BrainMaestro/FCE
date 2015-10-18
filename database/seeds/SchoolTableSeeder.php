<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schools')
            ->insert([
                [
                    'school' => 'SITC',
                    'description' => 'School of Information Technology and Computing'
                ],
                [
                    'school' => 'SAS',
                    'description' => 'School of Arts and Science'
                ],
                [
                    'school' => 'SBE',
                    'description' => 'School of Business and Entrepreneurship'
                ]
            ]);
    }
}
