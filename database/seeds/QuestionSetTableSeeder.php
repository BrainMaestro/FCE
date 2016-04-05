<?php

use Illuminate\Database\Seeder;

class QuestionSetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_sets')
            ->insert([
                ['name' => 'Original Midterm Question Set'],
                ['name' => 'Original Final Question Set'],
            ]);
    }
}
