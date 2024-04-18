<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//crea la ruta para obtener una tarea por id
Route::get('/tasks/{task}', [\App\Http\Controllers\Api\TaskController::class, 'show'])
    ->name('api.v1.tasks.show')
;

//crea la ruta para obtener el listado de tareas
Route::get('/tasks', [\App\Http\Controllers\Api\TaskController::class, 'index'])
    ->name('api.v1.tasks.index')

;

////crea la ruta para obtener el listado de tareas por status
//Route::get('/tasks/status/{status}', [\App\Http\Controllers\Api\TaskController::class, 'getTaskByStatus']);