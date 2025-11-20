<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GigController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are automatically prefixed with /api and use the "api"
| middleware group. CSRF is not applied here in Laravel’s defaults.
|
*/

Route::apiResource('gigs', GigController::class);
