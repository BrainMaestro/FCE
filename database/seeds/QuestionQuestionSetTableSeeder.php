<?php

use Illuminate\Database\Seeder;

class QuestionQuestionSetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insertValues = [];
        // Add first 15 questions to question_set 1
        foreach (range(1, 15) as $id) {
            $insertValues[] = [
                'question_id' => $id,
                'question_set_id' => 1,
                'position' => $id,
            ];
        }
        // Add the remaining 18 questions to question_set 2
        foreach (range(1, 18) as $id) {
            $insertValues[] = [
                'question_id' => $id + 15,
                'question_set_id' => 2,
                'position' => $id,
            ];
        }
        DB::table('question_question_set')->insert($insertValues);
    }
}
