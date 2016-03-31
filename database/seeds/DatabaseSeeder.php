<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $tables = [
        'roles',
        'schools',
        'questions',
        'question_sets',
        'question_question_set',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->truncateTables();

        $this->call(RoleTableSeeder::class);
        $this->call(SchoolTableSeeder::class);
        $this->call(QuestionTableSeeder::class);
        $this->call(QuestionSetTableSeeder::class);
        $this->call(QuestionQuestionSetTableSeeder::class);

        Model::reguard();
    }

    private function truncateTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($this->tables as $table) {
            DB::statement("truncate $table");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
