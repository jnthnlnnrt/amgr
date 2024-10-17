<?php

use App\Livewire\Assets\Computers;
use App\Livewire\Assets\Computers\Edit;
use App\Livewire\Assets\EditComputer;
use App\Livewire\Dashboard;
use App\Livewire\Organization\Departments;
use App\Livewire\Organization\Employees;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', Dashboard::class)->middleware('auth')->name('dashboard');

Route::get('/organization/departments', Departments::class)->middleware('auth')->name('departments');
Route::get('/organization/employees', Employees::class)->middleware('auth')->name('employees');

Route::get('/assets/computers', Computers::class)->middleware('auth')->name('computers');
Route::get('/assets/computers/edit/{id}', EditComputer::class)->middleware('auth')->name('edit-computer');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
