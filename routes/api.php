<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
Route::prefix('v1')->group(function () {
 Route::post('/reservations',[ApiController::class,'createReservation']);
 Route::get('/vehicles',[ApiController::class,'vehicles']);
 Route::post('/coupons/applications',[ApiController::class,'coupon']);
 Route::get('/vehicles/{id}/telemetry',[ApiController::class,'telemetry']);
 Route::put('/vehicles/{id}/driver',[ApiController::class,'driver']);
 Route::post('/vehicles/{id}/geofences',[ApiController::class,'geofence']);
 Route::post('/claims',[ApiController::class,'claim']);
 Route::post('/maintenance-appointments',[ApiController::class,'maintenance']);
 Route::get('/vehicles/{id}/maintenance-history',[ApiController::class,'history']);
 Route::get('/billing-statements',[ApiController::class,'billing']);
 Route::get('/traffic-fines',[ApiController::class,'fines']);
});