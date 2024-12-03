<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CourseAdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middlewares\RoleMiddleware;

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/course', [CourseController::class, 'index'])->name('course.index');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [IndexController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');



Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user', [UserController::class, 'index'])->name('profile.index');
    Route::post('/user/update-email', [UserController::class, 'updateEmail'])->name('user.updateEmail');
    Route::post('/user/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::put('/user/update-profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');

    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::patch('/account/{id}/verify', [AccountController::class, 'verify'])->name('account.verify');
    Route::post('/account', [AccountController::class, 'store'])->name('account.store');
    Route::put('/account/{user}', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account/{user}', [AccountController::class, 'destroy'])->name('account.destroy');
    Route::get('/account/search', [AccountController::class, 'search'])->name('account.search');

    // Route::middleware(['admin'])->group(function () {
    //     Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    //     Route::post('/account', [AccountController::class, 'store'])->name('account.store');
    //     Route::put('/account/{user}', [AccountController::class, 'update'])->name('account.update');
    //     Route::delete('/account/{user}', [AccountController::class, 'destroy'])->name('account.destroy');
    //     Route::get('/account/search', [AccountController::class, 'search'])->name('account.search');
    // });
    Route::get('/account', [AccountController::class, 'index'])
        ->middleware(EnsureUserIsAdmin::class)
        ->name('account.index');

    Route::post('/account', [AccountController::class, 'store'])
        ->middleware(EnsureUserIsAdmin::class)
        ->name('account.store');

    Route::put('/account/{user}', [AccountController::class, 'update'])
        ->middleware(EnsureUserIsAdmin::class)
        ->name('account.update');

    Route::delete('/account/{user}', [AccountController::class, 'destroy'])
        ->middleware(EnsureUserIsAdmin::class)
        ->name('account.destroy');

    Route::get('/account/search', [AccountController::class, 'search'])
        ->middleware(EnsureUserIsAdmin::class)
        ->name('account.search');
    

    Route::get('courses', [CourseAdminController::class, 'index'])->name('admin.course.index');
    Route::post('course', [CourseAdminController::class, 'store'])->name('course.store');
    Route::put('course/{course}', [CourseAdminController::class, 'update'])->name('course.update');
    Route::delete('course/{course}', [CourseAdminController::class, 'destroy'])->name('course.destroy');
    Route::get('/course/{id}/detail', [CourseAdminController::class, 'showDetail'])->name('course.showDetail');
    Route::post('/course/follow', [CourseAdminController::class, 'followCourse'])->name('course.follow');
    Route::post('/course/complete', [CourseAdminController::class, 'completeCourse'])->name('student.completeCourse');
    Route::get('/student/courses/{course}/certificate', [CourseAdminController::class, 'printCertificate'])->name('student.printCertificate');
    Route::get('activecourses', [CourseAdminController::class, 'activecourses'])->name('admin.course.activecourses');
    Route::get('progresstudent', [CourseAdminController::class, 'progresstudent'])->name('admin.course.progresstudent');



    Route::post('materi', [MateriController::class, 'store'])->name('materi.store');
    Route::put('/materi/{materi}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{materi}', [MateriController::class, 'destroy'])->name('materi.destroy');




});

require __DIR__.'/auth.php';
