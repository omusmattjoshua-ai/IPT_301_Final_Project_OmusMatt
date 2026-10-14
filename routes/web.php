<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\LabOrderController;
use App\Http\Controllers\LabResultController;
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('doctors', DoctorController::class);
Route::resource('patients', PatientController::class);
Route::resource('lab-tests', LabTestController::class)->parameters(['lab-tests' => 'labTest']);
Route::resource('lab-orders', LabOrderController::class)->parameters(['lab-orders' => 'labOrder']);
Route::resource('lab-results', LabResultController::class)->parameters(['lab-results' => 'labResult']);
