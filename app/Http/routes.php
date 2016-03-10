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
]);

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api'], function () {

    // Authentication Routes
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');

    // Evaluation Routes
    Route::get('/evaluations', 'EvaluationController@index');
    Route::put('/evaluations', 'EvaluationController@incrementEvaluation');

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
    Route::get('/sections/{id}/keys', 'SectionController@showKeys');
    Route::get('/sections/{id}/reports', 'SectionController@showReport');
    Route::get('/sections/{id}/evaluations', 'SectionController@showEvaluations');

    // Question Routes
    Route::get('/questions', 'QuestionController@index');
    Route::get('/questions/{id}', 'QuestionController@show');
    Route::post('/questions', 'QuestionController@create');


    // QuestionSet Routes
    Route::get('/question-sets', 'QuestionSetController@index');
    Route::get('/question-sets/{id}', 'QuestionSetController@show');
    Route::post('/question-sets', 'QuestionSetController@create');
    Route::post('/question-sets/{id}/questions', 'QuestionSetController@addQuestions');

    // School Routes
    Route::get('/schools', 'SchoolController@index');
    Route::get('/schools/{id}', 'SchoolController@show');
    Route::post('/schools', 'SchoolController@create');
    Route::put('/schools/{id}', 'SchoolController@update');

    // Semester Routes
    Route::get('/semesters', 'SemesterController@index');
    Route::post('/semesters', 'SemesterController@create');
    Route::put('/semesters/{id}', 'SemesterController@update');
    Route::post('/semesters/{id}/question-sets', 'SemesterController@addQuestionSet');
    Route::put('/semesters/{id}/question-sets/{questionSetId}', 'SemesterController@updateQuestionSetStatus');
});
