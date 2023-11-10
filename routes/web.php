<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Pages\Landing;
use Illuminate\Support\Facades\DB;
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
    Route::middleware('active.semester')->get('/dashboard', fn()=> 'redirect')->name('dashboard.redirect');
    Route::post('logout', LogoutController::class)->name('logout');

    Volt::route('/{semester}/dashboard', 'dashboard.index')->name('dashboard');

    Volt::route('/{semester}/objectives', 'objective.index')->name('objectives');
    Volt::route('/{semester}/takwim', 'takwim.index')->name('takwim');

    Route::get('/{semester}/curriculum', App\Livewire\Curricula\Views\Pages\ListCurricula::class)->name('curriculum.index');
    Route::get('/{semester}/curriculum/create', App\Livewire\Curricula\Views\Pages\CreateCurricula::class)->name('curriculum.create');
    Route::get('/{semester}/curriculum/{curricula}', App\Livewire\Curricula\Views\Pages\EditCurricula::class)->name('curriculum.edit');

    Route::get('/{semester}/profile/schools', App\Livewire\School\Views\Pages\EditSchool::class)->name('profile.schools.edit');

    Route::get('/{semester}/profile/teachers', App\Livewire\Teacher\Views\Pages\ListTeacher::class)->name('profile.teachers.index');
    Route::get('/{semester}/profile/teachers/create', App\Livewire\Teacher\Views\Pages\CreateTeacher::class)->name('profile.teachers.create');
    Route::get('/{semester}/profile/teachers/{teacher}/edit', App\Livewire\Teacher\Views\Pages\EditTeacher::class)->name('profile.teachers.edit');
    Route::get('/{semester}/profile/teachers/{teacher}/activities', App\Livewire\Teacher\Views\Pages\TeacherActivities::class)->name('profile.teachers.activities.index');

    Route::get('/{semester}/profile/committees', App\Livewire\Committee\Views\Pages\ListCommitee::class)->name('profile.committees.index');
    Route::get('/{semester}/profile/students', App\Livewire\Student\Views\Pages\ListStudent::class)->name('profile.students.index');

    Route::get('/{semester}/courses', App\Livewire\Course\Views\Pages\ListCourse::class)->name('courses.index');
    Route::get('/{semester}/courses/create', App\Livewire\Course\Views\Pages\CreateCourse::class)->name('courses.create');
    Route::get('/{semester}/courses/{annualCourse}/edit', App\Livewire\Course\Views\Pages\EditCourse::class)->name('courses.edit');

    Route::get('/{semester}/rph', App\Livewire\Rph\Views\Pages\ListRph::class)->name('rph.index');
    Route::get('/{semester}/rph/{rph}/timetables', App\Livewire\Timetable\Views\Pages\ListTimetable::class)->name('rph.timetable.index');
    Route::get('/{semester}/rph/{rph}/timetables/create', App\Livewire\Timetable\Views\Pages\CreateTimetable::class)->name('rph.timetable.create');
    Route::get('/{semester}/rph/{rph}/timetables/{timetable}/edit', App\Livewire\Timetable\Views\Pages\EditTimetable::class)->name('rph.timetable.edit');

    Route::get('/{semester}/rph/{rph}/timetables/summaries/{date_at}', App\Livewire\Timetable\Views\Pages\ShowTimetable::class)->name('rph.timetable.summaries');
});
