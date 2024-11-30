<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IveController;


Route::prefix('v1/Dr.ive')->group(function () {
    Route::post('store', [IveController::class, 'store']);
    Route::get('show/{id}', [IveController::class, 'show'])->where('id', '.*');
});
