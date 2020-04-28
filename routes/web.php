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

Route::get('home', 'HomeController@index')->name('home');

Route::prefix('teacher/{teacher}')->group(function () {
    Route::get('', 'TeacherController@home')->name('teacher.home');

    Route::prefix('class')->group(function () {
        Route::get('search', 'SubjectController@search')->name('teacher.subject.search')->middleware('strip.empty');
        Route::get('all', 'SubjectController@viewAll')->name('teacher.subject.viewAll');
        Route::get('', 'SubjectController@index')->name('teacher.subject.index');
        Route::get('create', 'SubjectController@create')->name('teacher.subject.create');
        Route::post('', 'SubjectController@store')->name('teacher.subject.store');

        Route::prefix('{subject}')->group(function () {
            Route::get('', 'SubjectController@show')->name('teacher.subject.show');
            Route::get('acceptAll', 'SubjectController@acceptAll')->name('teacher.subject.acceptAll');
            Route::get('accept/{student}', 'SubjectController@accept')->name('teacher.subject.accept');
            Route::get('remove/{student}', 'SubjectController@remove')->name('teacher.subject.remove');
            Route::get('edit', 'SubjectController@edit')->name('teacher.subject.edit');
            Route::patch('', 'SubjectController@update')->name('teacher.subject.update');
            Route::delete('', 'SubjectController@destroy')->name('teacher.subject.destroy');
        });
    });

    Route::prefix('exam')->group(function () {
        Route::get('', 'ExamController@index')->name('teacher.exam.index');
        Route::get('create', 'ExamController@create')->name('teacher.exam.create');
        Route::post('', 'ExamController@store')->name('teacher.exam.store');
        Route::get('all', 'ExamController@viewAll')->name('teacher.exam.viewAll');

        Route::prefix('{exam}')->group(function () {
            Route::get('', 'ExamController@show')->name('teacher.exam.show');
            Route::get('preview', 'ExamController@preview')->name('teacher.exam.preview');
            Route::get('edit', 'ExamController@edit')->name('teacher.exam.edit');
            Route::patch('', 'ExamController@update')->name('teacher.exam.update');
            Route::delete('', 'ExamController@destroy')->name('teacher.exam.destroy');
            Route::get('enable/{subject}', 'ExamController@enable')->name('teacher.exam.enable');

            Route::prefix('question')->group(function () {
                Route::get('create', 'QuestionController@create')->name('teacher.exam.question.create');
                Route::post('', 'QuestionController@store')->name('teacher.exam.question.store');
                Route::get('{question}{key}/edit', 'QuestionController@edit')->name('teacher.exam.question.edit');
                Route::patch('{question}', 'QuestionController@update')->name('teacher.exam.question.update');
                Route::delete('{question}', 'QuestionController@destroy')->name('teacher.exam.question.destroy');
            });
        });
    });
});

Route::prefix('student/{student}')->group(function () {
    Route::get('', 'StudentController@home')->name('student.home');

    Route::prefix('class')->group(function () {
        Route::get('', 'StudentController@index')->name('student.subject.index');
        Route::get('search', 'StudentController@search')->name('student.search')->middleware('strip.empty');
        Route::get('{subject}/enroll', 'StudentController@enroll')->name('student.subject.enroll');
        Route::get('all', 'StudentController@viewAll')->name('student.subject.viewAll');
    });

    Route::prefix('exam')->group(function () {
        Route::get('', 'ExamController@index')->name('student.exam.index');
    });
});

