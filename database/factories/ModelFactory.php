<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Fce\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('password'),
        'school_id' => (new Fce\Models\School())->first()->id,
        'remember_token' => str_random(10),
    ];
});

$factory->define(Fce\Models\Role::class, function (Faker\Generator $faker) {
    $role = $faker->randomElement(['admin', 'dean', 'executive', 'faculty', 'secretary']);

    return [
        'role' => $role,
        'display_name' => ucfirst($role),
    ];
});

$factory->define(Fce\Models\QuestionSet::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(Fce\Models\Semester::class, function (Faker\Generator $faker) {
    return [
        'season' => $faker->word,
        'year' => $faker->year,
        'current_semester' => false,
    ];
});

$factory->define(Fce\Models\School::class, function (Faker\Generator $faker) {
    return [
        'school' => $faker->word,
        'description' => $faker->sentence(10),
    ];
});

$factory->define(Fce\Models\Question::class, function (Faker\Generator $faker) {
    return [
        'category' => $faker->word,
        'title' => $faker->sentence,
        'description' => $faker->sentence(10),
    ];
});

$factory->define(Fce\Models\Section::class, function (Faker\Generator $faker) {
    return [
        'crn' => $faker->randomNumber(7),
        'course_code' => $faker->word,
        'semester_id' => (new Fce\Models\Semester())->first()->id,
        'school_id' => (new Fce\Models\School())->first()->id,
        'course_title' => $faker->sentence,
        'class_time' => $faker->time(),
        'location' => $faker->sentence,
        'status' => 'Locked',
        'enrolled' => $faker->randomNumber(1) + 1, // So that it'll never be zero
    ];
});

$factory->define(Fce\Models\Evaluation::class, function (Faker\Generator $faker) {
    return [
        'section_id' => (new Fce\Models\Section())->first()->id,
        'question_id' => (new Fce\Models\Question())->first()->id,
        'question_set_id' => (new Fce\Models\QuestionSet())->first()->id,
        'one' => $faker->randomNumber(1),
        'two' => $faker->randomNumber(1),
        'three' => $faker->randomNumber(1),
        'four' => $faker->randomNumber(1),
        'five' => $faker->randomNumber(1),
    ];
});

$factory->define(Fce\Models\Key::class, function () {
    return [
        'value' => strtoupper(str_random(6)),
        'section_id' => (new Fce\Models\Section())->first()->id,
    ];
});

$factory->define(Fce\Models\Comment::class, function (Faker\Generator $faker) {
    return [
        'section_id' => (new Fce\Models\Section)->first()->id,
        'question_set_id' => (new Fce\Models\QuestionSet())->first()->id,
        'comment' => $faker->sentence,
    ];
});
