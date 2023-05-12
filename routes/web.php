<?php

use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyectoController;
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

    Route::get('proyectos/{token}/aceptar_invitacion', [ProyectoController::class, 'aceptarInvitacion'])->name('proyectos.aceptar_invitacion');
    Route::post('proyectos/{proyecto}/enviar_invitacion', [ProyectoController::class, 'enviarInvitacion'])->name('proyectos.enviar_invitacion');
    Route::resource('proyectos', ProyectoController::class)->parameters([
        'proyectos' => 'proyecto'
    ]);

    Route::prefix('/proyectos/{proyecto}')->group(function(){
        
        Route::get('/dashboard', [ProyectoController::class, 'dashboard'])->name('proyectos.dashboard');
        Route::get('/tablero', [ProyectoController::class, 'tablero'])->name('proyectos.tablero');

        Route::resource('incidencias', IncidenciaController::class)->parameters([
            'proyectos' => 'proyecto',
            'incidencias' => 'incidencia'
        ]);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
