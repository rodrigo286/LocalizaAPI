<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::post('/reservations', [ApiController::class, 'createReservation']);
    Route::get('/vehicles', [ApiController::class, 'vehicles']);
    Route::post('/coupons/applications', [ApiController::class, 'applyCoupon']);

    Route::get('/vehicles/{vehicle}/telemetry', [ApiController::class, 'telemetry']);
    Route::put('/vehicles/{vehicle}/driver', [ApiController::class, 'linkDriver']);
    Route::post('/vehicles/{vehicle}/geofences', [ApiController::class, 'createGeofence']);

    Route::post('/claims', [ApiController::class, 'createClaim']);
    Route::post('/maintenance-appointments', [ApiController::class, 'scheduleMaintenance']);
    Route::get('/vehicles/{vehicle}/maintenance-history', [ApiController::class, 'maintenanceHistory']);

    Route::get('/billing-statements', [ApiController::class, 'billingStatements']);
    Route::get('/traffic-fines', [ApiController::class, 'trafficFines']);
});
