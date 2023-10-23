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
    Route::middleware('active.semester')->get('/dashboard', fn()=> 'redirect')->name('dashboard');
    Route::post('logout', LogoutController::class)->name('logout'); 

    Volt::route('/{semester}/dashboard', 'dashboard.index')->name('semester.dashboard');

    Volt::route('/{semester}/objectives', 'objective.index')->name('semester.objectives');
    Volt::route('/{semester}/takwim', 'takwim.index')->name('semester.takwim');

    Volt::route('/{semester}/curriculum', 'curriculum.index')->name('semester.curriculum.index');
    Volt::route('/{semester}/curriculum/create', 'curriculum.create')->name('semester.curriculum.create');
    Volt::route('/{semester}/curriculum/{curricula}', 'curriculum.edit')->name('semester.curriculum.edit');

    Volt::route('/{semester}/schools/create', 'school.create')->name('semester.schools.create');
    Volt::route('/{semester}/staffs', 'staff.index')->name('semester.staffs.index');

    Volt::route('/{semester}/courses', 'courses.index')->name('semester.courses.index');
    Volt::route('/{semester}/courses/create', 'courses.create')->name('semester.courses.create');
    Volt::route('/{semester}/courses/{annualCourse}/edit', 'courses.edit')->name('semester.courses.edit');
});