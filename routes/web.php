<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Pages\Landing;
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

    Volt::route('/{semester}/curriculum', 'curriculum.index')->name('curriculum.index');
    Volt::route('/{semester}/curriculum/create', 'curriculum.create')->name('curriculum.create');
    Volt::route('/{semester}/curriculum/{curricula}', 'curriculum.edit')->name('curriculum.edit');

    Volt::route('/{semester}/profile/schools', 'schools.edit')->name('profile.schools.edit');
    
    Volt::route('/{semester}/profile/teachers', 'teachers.index')->name('profile.teachers.index');
    Volt::route('/{semester}/profile/teachers/create', 'teachers.create')->name('profile.teachers.create');
    Volt::route('/{semester}/profile/teachers/create/{teacher}/edit', 'teachers.edit')->name('profile.teachers.edit');

    Volt::route('/{semester}/profile/committees', 'committees.index')->name('profile.committees.index');
    Volt::route('/{semester}/profile/committees/create', 'committees.create')->name('profile.committees.create');
    Volt::route('/{semester}/profile/committees/{committee}/edit', 'committees.edit')->name('profile.committees.edit');

    Volt::route('/{semester}/courses', 'courses.index')->name('courses.index');
    Volt::route('/{semester}/courses/create', 'courses.create')->name('courses.create');
    Volt::route('/{semester}/courses/{annualCourse}/edit', 'courses.edit')->name('courses.edit');
});