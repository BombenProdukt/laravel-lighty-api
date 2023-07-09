<?php

declare(strict_types=1);

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ThemeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use LaravelJsonApi\Laravel\Routing\Relationships;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('teams.documents', DocumentController::class)->except('update');

Route::apiResource('teams.languages', LanguageController::class);

Route::apiResource('teams.themes', ThemeController::class);

JsonApiRoute::server('v1')->prefix('v1')->resources(function (ResourceRegistrar $server): void {
    $server
        ->resource('teams', JsonApiController::class)
        ->relationships(function (Relationships $relationships): void {
            $relationships->hasMany('documents');
            $relationships->hasMany('languages');
            $relationships->hasMany('themes');
        })
        ->readOnly();

    // $server
    //     ->resource('documents', JsonApiController::class)
    //     ->except('update');

    // $server
    //     ->resource('languages', JsonApiController::class)
    //     ->except('update');

    // $server
    //     ->resource('themes', JsonApiController::class)
    //     ->except('update');
});
