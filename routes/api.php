<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Users\Controllers\UserController;
use \App\Modules\Auth\Controllers\LoginController;
use \App\Modules\Auth\Controllers\RegistrationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('login', [LoginController::class, 'login']);
Route::post('registration', [RegistrationController::class, 'register']);

Route::apiResource('/parser_results', \App\Modules\ParserResults\Controllers\ParserResultController::class)
    ->except(['index', 'store', 'update']);

Route::get('/parsers/start/{id}', [\App\Modules\Parsers\Controllers\ParserController::class, 'start']);
Route::apiResource('/parsers', \App\Modules\Parsers\Controllers\ParserController::class);

Route::get('users/change_pass/{id}', [UserController::class, 'change_pass']);
Route::apiResource('/users', UserController::class);

