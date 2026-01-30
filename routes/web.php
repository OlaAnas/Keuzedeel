<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/export/users', [\App\Http\Controllers\Admin\ExportToExcelController::class, 'exportUsersExcel']);
});

// Dashboard redirect based on role
Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect('/admin/dashboard'),
        'student' => redirect('/student/keuzedelen'),
        'slb' => redirect('/slb/dashboard'),
        'teacher' => redirect('/teacher/dashboard'),
        default => redirect('/login'),
    };
})->middleware('auth')->name('dashboard');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('keuzedelen', \App\Http\Controllers\Admin\KeuzedelController::class);
    Route::patch('/keuzedelen/{id}/toggle-active', [\App\Http\Controllers\Admin\KeuzedelController::class, 'toggleActive'])->name('admin.keuzedelen.toggle-active');

    Route::resource('teachers', \App\Http\Controllers\Admin\TeacherController::class);

    Route::get('/students/import', [\App\Http\Controllers\Admin\StudentController::class, 'import'])->name('students.import');
    Route::post('/students/import', [\App\Http\Controllers\Admin\StudentController::class, 'storeImport'])->name('students.store-import');
    Route::resource('students', \App\Http\Controllers\Admin\StudentController::class);

    Route::resource('periods', \App\Http\Controllers\Admin\PeriodController::class, ['only' => ['index', 'edit', 'update']]);
    Route::patch('/periods/{id}/toggle-enrollment', [\App\Http\Controllers\Admin\PeriodController::class, 'toggleEnrollment'])->name('periods.toggle-enrollment');

    Route::get('/enrollments', [\App\Http\Controllers\Admin\EnrollmentController::class, 'index'])->name('admin.enrollments');
    Route::patch('/enrollments/{id}/cancel', [\App\Http\Controllers\Admin\EnrollmentController::class, 'cancel'])->name('admin.enrollments.cancel');
    Route::patch('/enrollments/{id}/restore', [\App\Http\Controllers\Admin\EnrollmentController::class, 'restore'])->name('admin.enrollments.restore');

    Route::get('/waitlists', [\App\Http\Controllers\Admin\WaitlistController::class, 'index'])->name('admin.waitlists');
    Route::patch('/waitlists/{id}/approve', [\App\Http\Controllers\Admin\WaitlistController::class, 'approve'])->name('admin.waitlists.approve');
    Route::patch('/waitlists/{id}/reject', [\App\Http\Controllers\Admin\WaitlistController::class, 'reject'])->name('admin.waitlists.reject');
});

// Student routes
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/keuzedelen', [\App\Http\Controllers\StudentController::class, 'keuzedelen'])->name('student.keuzedelen');
    Route::get('/keuzedelen/{id}', [\App\Http\Controllers\StudentController::class, 'keuzedelenDetail'])->name('student.keuzedeel-detail');
    Route::get('/mijn-inschrijving', [\App\Http\Controllers\EnrollmentController::class, 'myEnrollments'])->name('student.my-enrollments');
    Route::post('/keuzedelen/{id}/enroll', [\App\Http\Controllers\EnrollmentController::class, 'enroll'])->name('student.enroll');
    Route::post('/enrollments/{id}/unenroll', [\App\Http\Controllers\EnrollmentController::class, 'unenroll'])->name('student.unenroll');
});

// SLB routes
Route::middleware(['auth', 'role:slb'])->prefix('slb')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SLB\PresentationController::class, 'dashboard'])->name('slb.dashboard');
    Route::get('/presentation', [\App\Http\Controllers\SLB\PresentationController::class, 'index'])->name('slb.presentation');
    Route::post('/presentation/next', [\App\Http\Controllers\SLB\PresentationController::class, 'next'])->name('slb.presentation.next');
    Route::post('/presentation/previous', [\App\Http\Controllers\SLB\PresentationController::class, 'previous'])->name('slb.presentation.previous');
    Route::post('/presentation/reset', [\App\Http\Controllers\SLB\PresentationController::class, 'reset'])->name('slb.presentation.reset');
});

// Teacher routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');
});
