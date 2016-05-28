<?php

use Fce\Models\Question;
use Fce\Models\QuestionSet;
use Fce\Models\Section;
use Fce\Models\Semester;
use Illuminate\Database\Seeder;

/**
 * Created by BrainMaestro.
 * Date: 4/21/16
 * Time: 11:28 AM.
 */
class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $semesters = factory(Semester::class, 3)->create();
        $sections = factory(Section::class, 5)->create([
            'semester_id' => $semesters[0]->id,
        ]);
        factory(QuestionSet::class, 3)->create();
        factory(Question::class, 10)->create();
        $users = factory(\Fce\Models\User::class, 5)->create();

        // Set first semester as current semester.
        $semester = Semester::first();
        $semester->current_semester = true;
        $semester->save();

        // Attach all questions to first question set.
        $questionSet = QuestionSet::first();
        $questionSet->questions()->attach(Question::all());

        // Attach all question sets to first semester.
        $semester->questionSets()->attach(QuestionSet::all());

        // Add users to sections *instructors*
        $sections[0]->users()->attach([$users[0]->id, $users[1]->id]);
        $sections[1]->users()->attach($users[4]->id);
        $sections[2]->users()->attach([$users[2]->id, $users[3]->id, $users[4]->id]);
        $sections[3]->users()->attach([$users[3]->id, $users[0]->id]);
        $sections[4]->users()->attach($users[2]->id);

        $users[0]->roles()->attach(1);
    }
}
