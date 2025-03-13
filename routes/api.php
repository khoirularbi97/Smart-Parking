<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DeviceController;
Route::get('/device/on', [DeviceController::class, 'turnOn']);
Route::get('/device/off', [DeviceController::class, 'turnOff']);
