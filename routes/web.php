<?php

use App\Http\Controllers\AcademicController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/project-idea', [PageController::class, 'project'])->name('project');
Route::get('/projects', [PageController::class, 'projects'])->name('projects');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/collection', [PageController::class, 'collection'])->name('collection');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'article'])->name('article');
Route::get('/kalkulator', [PageController::class, 'calculator'])->name('calculator');
Route::get('/kalkulator/submit', [PageController::class, 'calculateForm'])->name('calculator.submit');
Route::get('/hitung/{angka1}/{angka2}/{operasi}', [PageController::class, 'hitung'])->name('calculate');

// Week 2: required and optional parameters, named routes, and grouped routes.
Route::get('/mahasiswa/{nrp}', [AcademicController::class, 'profile'])->where('nrp', '[0-9]{10}')->name('student');
Route::get('/agent/{tema?}', [AcademicController::class, 'agent'])->name('agent');
Route::get('/hitung-ipk/{ip1}/{ip2}', [AcademicController::class, 'gpa'])->name('gpa.calculate');
Route::prefix('dashboard')->name('dashboard.')->controller(AcademicController::class)->group(function () {
    Route::get('/', 'dashboard')->name('index');
    Route::get('/mahasiswa/{nrp}', 'profile')->where('nrp', '[0-9]{10}')->name('student');
    Route::get('/agent/{tema?}', 'agent')->name('agent');
    Route::get('/ipk', 'gpaForm')->name('gpa');
    Route::get('/ipk/submit', 'submit')->name('gpa.submit');
});
Route::fallback([AcademicController::class, 'missing'])->name('fallback');
