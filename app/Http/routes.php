<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::patterns([
    'id' => '[0-9]+',
    'questionSetId' => '[0-9]+',
    'key' => '[A-Z0-9]{' . \Fce\Models\Key::LENGTH . '}',
]);

Route::get('/', function () {
    return view('index');
});

// Password Reset Routes
Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Authentication Routes
Route::post('/login', 'Auth\AuthController@login');
Route::delete('/logout', ['uses' => 'Auth\AuthController@login', 'middleware' => 'jwt.auth']);

Route::group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function () {

    // Evaluation Routes
    Route::get('/evaluations/{key}', 'EvaluationController@index');
    Route::put('/evaluations/{key}', 'EvaluationController@submitEvaluations');

    // Routes that require authentication
    Route::group(['middleware' => ['jwt.auth', 'token.refresh']], function () {

        // Search Route
        Route::get('/search', 'SearchController@index');

        // User Routes
        Route::get('/users', 'UserController@index');
        Route::get('/users/{id}', 'UserController@show');
        Route::post('/users', 'UserController@create');
        Route::delete('/users/{id}', 'UserController@destroy');
        Route::put('/users/{id}', 'UserController@update');

        // Section Routes
        Route::get('/sections', 'SectionController@index');
        Route::get('/sections/{id}', 'SectionController@show');
        Route::post('/sections', 'SectionController@create');
        Route::put('/sections/{id}', 'SectionController@update');
        Route::patch('/sections/{id}/status', 'SectionController@updateStatus');
        Route::get('/sections/{id}/keys', 'SectionController@showKeys');
        Route::get('/sections/{id}/reports', 'SectionController@listReports');
        // Not technically restful but no one cares anymore.
        Route::get('/sections/{id}/report/{questionSetId}', 'SectionController@showReport');

        // Question Routes
        Route::get('/questions', 'QuestionController@index');
        Route::get('/questions/{id}', 'QuestionController@show');
        Route::post('/questions', 'QuestionController@create');

        // QuestionSet Routes
        Route::get('/question_sets', 'QuestionSetController@index');
        Route::get('/question_sets/{id}', 'QuestionSetController@show');
        Route::post('/question_sets', 'QuestionSetController@create');
        Route::post('/question_sets/{id}/questions', 'QuestionSetController@addQuestions');

        // School Routes
        Route::get('/schools', 'SchoolController@index');
        Route::get('/schools/{id}', 'SchoolController@show');
        Route::post('/schools', 'SchoolController@create');
        Route::put('/schools/{id}', 'SchoolController@update');

        // Semester Routes
        Route::get('/semesters', 'SemesterController@index');
        Route::post('/semesters', 'SemesterController@create');
        Route::put('/semesters/{id}', 'SemesterController@update');
        Route::post('/semesters/{id}/question_sets', 'SemesterController@addQuestionSet');
        Route::put('/semesters/question_sets/{questionSetId}', 'SemesterController@updateQuestionSetStatus');
    });
});
