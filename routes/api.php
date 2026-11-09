<?php

use App\Http\Controllers\Api\SyncJobController;
use Illuminate\Support\Facades\Route;

Route::get('/jobs', [SyncJobController::class, 'index']);
Route::post('/jobs', [SyncJobController::class, 'store']);
Route::post('/jobs/{syncJob}/requeue', [SyncJobController::class, 'requeue']);
