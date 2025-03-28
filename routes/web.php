<?php

use App\Http\Controllers\MoldesController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\WeeklyPlannerController;
use App\Models\Moldes;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('moldes', [MoldesController::class, 'index'])->name('moldes');
Route::post('guardarmolde', [MoldesController::class, 'store'])->name('guardarmolde');

Route::get('plandetrabajo', [PlanController::class, 'index'])->name('plandetrabajo');

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function () {
    Route::get('/weekly-planner', [WeeklyPlannerController::class, 'show'])->name('weekly-planner');
    Route::post('/weekly-planner/settings', [WeeklyPlannerController::class, 'updateSettings'])->name('weekly-planner.settings');
    Route::post('/weekly-planner/tasks', [WeeklyPlannerController::class, 'storeTask'])->name('weekly-planner.tasks.store');
    // Otras rutas para actualizar/eliminar tareas
});