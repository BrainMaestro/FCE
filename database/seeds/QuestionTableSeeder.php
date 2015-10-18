<?php

use Illuminate\Database\Seeder;

class QuestionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')
            ->insert([
                [
                    'id' => 1,
                    'type' => 'mid',
                    'created_at' => '0000-00-00 00:00:00'
                ],
                [
                    'id' => 2,
                    'type' => 'final',
                    'created_at' => '0000-00-00 00:00:00'
                ]
            ]);
    }
}
