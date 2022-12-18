<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TestController;
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

// Действия с дисциплинами

Route::get('/disciplines', [DisciplineController::class, 'getDisciplines'])->middleware('auth')->name('getDisciplines');
Route::post('/disciplineSubscribe', [DisciplineController::class, 'subscribe'])->middleware('auth')->name('disciplineSubscribe');

// Действия с тестами

Route::get('/tests', [TestController::class, 'getTests'])->middleware('auth')->name('getTests');
Route::get('/addTest', [TestController::class, 'addTestView'])->middleware('auth')->name('addTest');
Route::post('/editTestView', [TestController::class, 'editTestView'])->middleware('auth')->name('editTestView');
Route::get('/test/{id}', [TestController::class, 'startTest'])->middleware('auth')->name('startTest');
Route::get('/test/{id}/result', [TestController::class, 'testResult'])->middleware('auth')->name('testResult');
Route::get('/mytests', [TestController::class, 'myTests'])->middleware('auth')->name('myTests');

// Действия с вопросами

Route::get('/questions', [QuestionController::class, 'getQuestions'])->middleware('auth')->name('getQuestions');
Route::get('/addQuestion', [QuestionController::class, 'addQuestionView'])->middleware('auth')->name('addQuestion');
Route::get('/test/{id}/{question}', [QuestionController::class, 'renderQuestion'])->middleware('auth')->name('renderQuestion');
Route::post('/submitQuestion', [QuestionController::class, 'submitQuestion'])->middleware('auth')->name('submitQuestion');

// Базовые CRUD апишки

Route::post('/addDiscipline', [DisciplineController::class, 'addDiscipline'])->middleware('auth')->name('addDiscipline');
Route::post('/editDiscipline', [DisciplineController::class, 'editDiscipline'])->middleware('auth')->name('editDiscipline');
Route::post('/deleteDiscipline', [DisciplineController::class, 'deleteDiscipline'])->middleware('auth')->name('deleteDiscipline');

Route::post('/addTest', [TestController::class, 'addTest'])->middleware('auth')->name('addTest');
Route::post('/deleteTest', [TestController::class, 'deleteTest'])->middleware('auth')->name('deleteTest');
Route::post('/editTest', [TestController::class, 'editTest'])->middleware('auth')->name('editTest');

Route::post('/addQuestion', [QuestionController::class, 'addQuestion'])->middleware('auth')->name('addQuestion');
Route::post('/deleteQuestion', [QuestionController::class, 'deleteQuestion'])->middleware('auth')->name('deleteQuestion');

// Main

Route::view('/main', 'user.main')->middleware('auth')->name('main');
Route::view('/', 'user.main')->middleware('auth')->name('main');

// Работа с правами

Route::get('/makeAdmin', [AdminController::class, 'makeAdmin'])->middleware('auth')->name('makeAdmin');
Route::get('/makeUser', [AdminController::class, 'makeUser'])->middleware('auth')->name('makeUser');
Route::get('/makeTeacher', [AdminController::class, 'makeTeacher'])->middleware('auth')->name('makeTeacher');



// Аутентификация

Route::get('/registration', function (){
    if(Auth::check()){
        return redirect(route('main'));
    }
    return view('authentication.registration');
})->name('registration');
Route::get('/login', function (){
    if(Auth::check()){
        return redirect(route('main'));
    }
    return view('authentication.login');
})->name('login');
Route::post('/registration', [RegistrationController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
