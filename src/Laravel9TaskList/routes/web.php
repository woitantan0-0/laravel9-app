<?php

use Illuminate\Support\Facades\Route;
/* TaskControllerクラスを名前空間でインポートする */
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Laravel welcome Page */
Route::get('/', function () {
    return view('welcome');
});
/* index page */
Route::get("/tasks", [TaskController::class,"index"])->name("tasks.index");
/* task create page */
Route::get('/tasks/create', [TaskController::class,"showCreateForm"])->name('tasks.create');
Route::post('/tasks/create', [TaskController::class,"create"]);
Route::get('/tasks/{task_id}/edit', [TaskController::class,"showEditForm"])->name('tasks.edit');
Route::post('/tasks/{task_id}/edit', [TaskController::class,"edit"]);
