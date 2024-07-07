<?php

use App\Http\Controllers\SubjectController;
use App\Models\Subject;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




// routes/web.php
// Route::middleware('auth')->group(function () {
//     Route::get('/Subjects', [SubjectController::class , 'index'])->name('Subjects.index');
//     Route::post('/Subjects/{Subject}/enroll', [SubjectController::class,'enroll'])->name('Subjects.enroll');
//     Route::get('/enrolled-Subjects', [SubjectController::class,'enrolledSubjects'])->name('Subjects.enrolled');
// });

// Route::get('enroll',[SubjectController::class,'enroll'])->name('enroll');
// Route::get('enrollment_form',[SubjectController::class,'showEnrollement']);
