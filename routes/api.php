<?php

use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TesteController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//   return $request->user();
// });

Route::prefix('v1')->group(function () {
  Route::get('/users', [UserController::class, 'index']);

  Route::post('/login', [AuthController::class, 'login']);
  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/teste', [TesteController::class, 'index'])->middleware('ability:teste-index');
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('ability:user-get');
    Route::post('/logout', [AuthController::class, 'logout']);
  });

  Route::apiResource('invoices', InvoiceController::class);
});
