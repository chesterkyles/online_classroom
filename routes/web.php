<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes(['verify' => true]);

// HomeController
Route::get('/home', 'HomeController@index')->name('home');

// TeacherController
Route::get('/teacher/{teacher}', 'TeacherController@home')->name('teacher.home');
// Teacher -> SubjectController
Route::get('/teacher/{teacher}/class/search', 'SubjectController@search')->name('teacher.subject.search')->middleware('strip.empty');
Route::get('/teacher/{teacher}/class/all', 'SubjectController@viewAll')->name('teacher.subject.viewAll');
Route::get('/teacher/{teacher}/class', 'SubjectController@index')->name('teacher.subject.index');
Route::get('/teacher/{teacher}/class/create', 'SubjectController@create')->name('teacher.subject.create');
Route::post('/teacher/{teacher}/class', 'SubjectController@store')->name('teacher.subject.store');
Route::get('/teacher/{teacher}/class/{subject}', 'SubjectController@show')->name('teacher.subject.show');
Route::get('/teacher/{teacher}/class/{subject}/acceptAll', 'SubjectController@acceptAll')->name('teacher.subject.acceptAll');
Route::get('/teacher/{teacher}/class/{subject}/accept/{student}', 'SubjectController@accept')->name('teacher.subject.accept');
Route::get('/teacher/{teacher}/class/{subject}/remove/{student}', 'SubjectController@remove')->name('teacher.subject.remove');
Route::get('/teacher/{teacher}/class/{subject}/edit', 'SubjectController@edit')->name('teacher.subject.edit');
Route::patch('/teacher/{teacher}/class/{subject}', 'SubjectController@update')->name('teacher.subject.update');
Route::delete('/teacher/{teacher}/class/{subject}', 'SubjectController@destroy')->name('teacher.subject.destroy');
// Teacher -> ExamController
Route::get('/teacher/{teacher}/exam', 'ExamController@index')->name('teacher.exam.index');
Route::get('/teacher/{teacher}/exam/create', 'ExamController@create')->name('teacher.exam.create');
Route::post('/teacher/{teacher}/exam', 'ExamController@store')->name('teacher.exam.store');
Route::get('/teacher/{teacher}/exam/all', 'ExamController@viewAll')->name('teacher.exam.viewAll');
Route::get('/teacher/{teacher}/exam/{exam}', 'ExamController@show')->name('teacher.exam.show');
Route::get('/teacher/{teacher}/exam/{exam}/preview', 'ExamController@preview')->name('teacher.exam.preview');
Route::get('/teacher/{teacher}/exam/{exam}/edit', 'ExamController@edit')->name('teacher.exam.edit');
Route::patch('/teacher/{teacher}/exam/{exam}', 'ExamController@update')->name('teacher.exam.update');
Route::delete('/teacher/{teacher}/exam/{exam}', 'ExamController@destroy')->name('teacher.exam.destroy');
Route::get('/teacher/{teacher}/exam/{exam}/enable/{subject}', 'ExamController@enable')->name('teacher.exam.enable');
// Teacher -> Exam -> QuestionController
Route::get('/teacher/{teacher}/exam/{exam}/question/create', 'QuestionController@create')->name('teacher.exam.question.create');
Route::post('/teacher/{teacher}/exam/{exam}/question', 'QuestionController@store')->name('teacher.exam.question.store');
Route::get('/teacher/{teacher}/exam/{exam}/question/{question}{key}/edit', 'QuestionController@edit')->name('teacher.exam.question.edit');
Route::patch('/teacher/{teacher}/exam/{exam}/question/{question}', 'QuestionController@update')->name('teacher.exam.question.update');
Route::delete('/teacher/{teacher}/exam/{exam}/question/{question}', 'QuestionController@destroy')->name('teacher.exam.question.destroy');

// StudentController
Route::get('/student/{student}', 'StudentController@home')->name('student.home');
Route::get('/student/{student}/class', 'StudentController@index')->name('student.subject.index');
Route::get('/student/{student}/class/search', 'StudentController@search')->name('student.search')->middleware('strip.empty');
Route::get('/student/{student}/class/{subject}/enroll', 'StudentController@enroll')->name('student.subject.enroll');
Route::get('/student/{student}/class/all', 'StudentController@viewAll')->name('student.subject.viewAll');

Route::get('/student/{student}/exam', 'ExamController@index')->name('student.exam.index');


