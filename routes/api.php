<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use DoxHunter\NovaCalendarTool\Http\Controllers\EventsController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/events', [EventsController::class, 'index']);
Route::post('/events/store', [EventsController::class, 'store']);
Route::put('/events/{event_id}/update', [EventsController::class, 'update']);
Route::delete('/events/{event_id}/destroy', [EventsController::class, 'destroy']);
