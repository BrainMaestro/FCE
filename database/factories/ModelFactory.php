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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    $role = $faker->randomElement(['admin', 'dean', 'executive', 'faculty', 'secretary']);
    return [
        'role' => $role,
        'display_name' => ucfirst($role),
    ];
});

$factory->define(App\Models\QuestionSet::class, function (Faker\Generator $faker) {
    return [
        'category' => $faker->word,
        'title' => $faker->sentence,
        'description' => $faker->sentence(10),
    ];
});

$factory->define(App\Models\Semester::class, function (Faker\Generator $faker) {
    return [
        'semester' => $faker->word,
    ];
});

$factory->define(App\Models\School::class, function (Faker\Generator $faker) {
    return [
        'school' => $faker->word,
        'description' => $faker->sentence(10),
    ];
});

$factory->define(App\Models\Question::class, function (Faker\Generator $faker) {
    return [
        'category' => $faker->word,
        'title' => $faker->sentence,
        'description' => $faker->sentence(10),
    ];
});

$factory->define(App\Models\Section::class, function (Faker\Generator $faker) {
    return [
        'crn' => $faker->randomNumber(7),
        'course_code' => $faker->word,
        'semester_id' => 1,
        'school_id' => 1,
        'course_title' => $faker->sentence,
        'class_time' => $faker->time(),
        'location' => $faker->sentence,
        'status' => 'Locked',
        'enrolled' => $faker->randomNumber(2),
    ];
});

$factory->define(App\Models\Evaluation::class, function (Faker\Generator $faker) {
    return [
        'section_id' => 1,
        'question_id' => 1,
    ];
});

