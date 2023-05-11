<?php

use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TableroController;
use App\Models\Proyecto;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return to_route('login');
});

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('proyectos', ProyectoController::class)->parameters([
        'proyectos' => 'proyecto'
    ]);

    Route::prefix('/proyecto/{proyecto}')->group(function(){
        Route::resource('incidencias', IncidenciaController::class)->parameters([
            'proyectos' => 'proyecto',
            'incidencias' => 'incidencia'
        ]);
    });

    // Route::resource('incidencias', IncidenciaController::class)->parameters([
    //     'proyectos' => 'proyecto',
    //     'incidencias' => 'incidencia'
    // ])->shallow();

    Route::get('/tableros', [TableroController::class, 'index'])->name('tableros');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
