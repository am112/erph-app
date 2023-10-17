<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Pages\Dashboard;
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
    Route::get('/{semester}/schools/create', CreateSchool::class)->name('semester.schools.create');

    Route::get('/{semester}/staffs', ListStaff::class)->name('semester.staffs.index');

    Route::post('logout', LogoutController::class)->name('logout'); 
});