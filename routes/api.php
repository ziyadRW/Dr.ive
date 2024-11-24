<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1/Dr.ive')->group(function () {

    Route::post('ives', [IveController::class, 'store']);
    Route::get('ives/{id}', [IveController::class, 'show']);

});
