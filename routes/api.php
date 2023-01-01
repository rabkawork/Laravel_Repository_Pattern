<?php

use App\Http\Controllers\AsksessionController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\CreditlogController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\Asksession;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('kosts', [KostController::class,'index']);
Route::get('kosts/owner', [KostController::class,'listowner'])->middleware(['auth:sanctum', 'checkapi.permission:owner']);
Route::get('kosts/{id}', [KostController::class,'show']);
Route::post('kosts', [KostController::class,'store'])->middleware(['auth:sanctum', 'checkapi.permission:owner']);
Route::put('kosts/{id}', [KostController::class,'update'])->middleware(['auth:sanctum', 'checkapi.permission:owner']);
Route::delete('kosts/{id}', [KostController::class,'destroy'])->middleware(['auth:sanctum', 'checkapi.permission:owner']);

Route::get('rooms', [RoomController::class,'index']);
Route::get('rooms/{id}', [RoomController::class,'show'])->middleware(['auth:sanctum', 'checkapi.permission:owner']);
Route::post('rooms', [RoomController::class,'store'])->middleware(['auth:sanctum', 'checkapi.permission:owner']);
Route::put('rooms/{id}', [RoomController::class,'update'])->middleware(['auth:sanctum', 'checkapi.permission:owner']);
Route::delete('rooms/{id}', [RoomController::class,'destroy'])->middleware(['auth:sanctum', 'checkapi.permission:owner']);

Route::get('usage', [CreditlogController::class,'index'])->middleware(['auth:sanctum', 'checkapi.permission:owner,regular,premium']);
Route::post('ask-owner', [AsksessionController::class,'store'])->middleware(['auth:sanctum', 'checkapi.permission:regular,premium']);
Route::middleware('auth:sanctum')->group( function () {
    Route::get('/logout', [UserController::class, 'logout']);
});

