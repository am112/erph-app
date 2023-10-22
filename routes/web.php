<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Pages\Courses\CreateCourse;
use App\Livewire\Pages\Courses\EditCourse;
use App\Livewire\Pages\Courses\ListCourse;
use App\Livewire\Pages\Dashboard;
use App\Livewire\Pages\Curriculum\CreateCurriculum;
use App\Livewire\Pages\Curriculum\EditCurriculum;
use App\Livewire\Pages\Curriculum\ListCurriculum;
use App\Livewire\Pages\Landing;
use App\Livewire\Pages\School\CreateSchool;
use App\Livewire\Pages\Staff\ListStaff;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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
Route::redirect('home', '/')->name('home');
Route::middleware('redirect.dashboard')->get('/', Landing::class);
Volt::route('/login', 'auth.login')->middleware('guest')->name('login');

Route::middleware(['auth', 'not.admin'])
->group(function(){
    Route::middleware('active.semester')->get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/{semester}/dashboard', Dashboard::class)->name('semester.dashboard');
    Route::get('/{semester}/curriculum', ListCurriculum::class)->name('semester.curriculum.index');
    Route::get('/{semester}/curriculum/create', CreateCurriculum::class)->name('semester.curriculum.create');
    Route::get('/{semester}/curriculum/{curricula}', EditCurriculum::class)->name('semester.curriculum.edit');

    Route::get('/{semester}/schools/create', CreateSchool::class)->name('semester.schools.create');

    Route::get('/{semester}/courses', ListCourse::class)->name('semester.courses.index');
    Route::get('/{semester}/courses/create', CreateCourse::class)->name('semester.courses.create');
    Route::get('/{semester}/courses/{annualCourse}/edit', EditCourse::class)->name('semester.courses.edit');


    Route::get('/{semester}/staffs', ListStaff::class)->name('semester.staffs.index');

    Route::post('logout', LogoutController::class)->name('logout'); 

    Volt::route('/{semester}/objectives', 'objective.index')->name('semester.objectives');
    Volt::route('/{semester}/takwim', 'takwim.index')->name('semester.takwim');
});

// Route::get('month', function(){
//     \Carbon\Carbon::setLocale('ms');
//     $d = \Carbon\Carbon::parse('2023-01-01');
//     // dd($d);
//     dd($d->format('F'));
// });