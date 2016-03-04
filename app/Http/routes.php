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

Route::pattern('id', '[0-9]+');

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api'], function() {

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
    Route::delete('/users', 'UserController@destroy');
    Route::put('/users', 'UserController@update');

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
    Route::post('/questions', 'QuestionController@create');
    Route::put('/questions', 'QuestionController@update');

    // QuestionSet Routes
    Route::get('/question-sets', 'QuestionSetController@index');
    Route::post('/question-sets/{id}', 'QuestionSetController@create');
    Route::put('/question-sets/{id}', 'QuestionSetController@update');

    // School Routes
    Route::get('/schools', 'SchoolController@index');
    Route::post('/schools', 'SchoolController@create');
    Route::put('/schools/{id}', 'SchoolController@update');

    // Semester Routes
    Route::get('/semesters', 'SemesterController@index');
    Route::post('/semesters', 'SemesterController@create');
    Route::put('/semesters/{id}', 'SemesterController@update');
});
