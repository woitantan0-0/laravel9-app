<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
/* TaskControllerクラスを名前空間でインポートする */
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Laravel welcome Page */
// Route::get('/welcome', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* home page */
    Route::get('/', [HomeController::class,"index"])->name('home');
    Route::get('/home', [HomeController::class,"index"])->name('home');
    /* index page */
    Route::get("/tasks", [TaskController::class,"index"])->name("tasks.index");
    /* task create page */
    Route::get('/tasks/create', [TaskController::class,"showCreateForm"])->name('tasks.create');
    Route::post('/tasks/create', [TaskController::class,"create"]);

    Route::middleware('can:view,task')->group(function () {
        Route::get('/tasks/{task}/edit', [TaskController::class,"showEditForm"])->name('tasks.edit');
        Route::post('/tasks/{task}/edit', [TaskController::class,"edit"]);
        Route::get('/tasks/{task}/delete', [TaskController::class,"showDeleteForm"])->name('tasks.delete');
        Route::post('/tasks/{task}/delete', [TaskController::class,"delete"]);
    });
});

require __DIR__.'/auth.php';
