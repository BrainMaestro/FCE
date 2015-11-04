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

Route::get('/', function () {
    return view('welcome');
});

//Home Route
//Route::get('/', 'HomeController@index');
Route::post('/login', 'HomeController@login');
Route::post('/logout', 'HomeController@logout');

//Evaluation Routes
Route::get('/evaluations', 'EvaluationController@index');
Route::post('/evaluations', 'EvaluationController@create');
Route::get('/evaluations/keys', 'EvaluationController@showKeys');
Route::get('/evaluations/json-keys', 'EvaluationController@showKeysJson');
Route::get('/evaluations/{id}', 'EvaluationController@show');

//User Routes
Route::get('/users', 'UserController@index');
Route::get('/users/{id}', 'UserController@show');
Route::post('/users', 'UserController@create');
Route::delete('/users', 'UserController@destroy');
Route::put('/users', 'UserController@update');

//Section Routes
Route::get('/sections', 'SectionController@index');
Route::get('/sections/{id}', 'SectionController@show');
Route::post('/sections', 'SectionController@create');
Route::put('/sections/{id}', 'SectionController@update');
Route::get('/sections/{id}/reports', 'SectionController@showReports');
Route::get('/sections/{id}/reports/{question_set_id}', 'SectionController@showSingleReport');

//QuestionSet Routes
Route::get('/questions', 'SectionController@index');
Route::post('/questions', 'SectionController@create');
Route::put('/questions/{question_set_id}', 'SectionController@update');

//School Routes
Route::get('/schools', 'SectionController@index');
Route::post('/schools', 'SectionController@create');
Route::put('/schools/{id}', 'SectionController@update');

//Semester Routes
Route::get('/semesters', 'SectionController@index');
Route::get('/semesters/current', 'SectionController@showCurrentSemester'); //@todo We may not need this route
Route::post('/semesters', 'SectionController@create');
Route::put('/semesters{id}', 'SectionController@update');
