<?php

use App\Http\Controllers\MoldesController;
use App\Http\Controllers\PlanController;
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
