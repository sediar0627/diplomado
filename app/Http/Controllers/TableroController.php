<?php

namespace App\Http\Controllers;

use App\Enums\EstadoIncidencia;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TableroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tablero = $request->get('tablero');
        
        if(!$tablero){
            return to_route('dashboard')->with('error', 'No se ha especificado un tablero.');
        }

        $tipoIncidencias = [];

        foreach (EstadoIncidencia::cases() as $estado) {
            $tipoIncidencias[$estado->value] = [];
        }

        if($tablero == 'ScrumPro'){
            $tipoIncidencias[EstadoIncidencia::PENDIENTE->value][] = [
                'titulo' => 'Prueba 1',
                'codigo' => 'scp-1',
                'puntos' => null,
                'encargado' => null,
            ];

            $tipoIncidencias[EstadoIncidencia::PENDIENTE->value][] = [
                'titulo' => 'Prueba 2',
                'codigo' => 'scp-2',
                'puntos' => null,
                'encargado' => 'Sergio Sánchez',
            ];

            $tipoIncidencias[EstadoIncidencia::TEST->value][] = [
                'titulo' => 'Prueba 3',
                'codigo' => 'scp-3',
                'puntos' => 32,
                'encargado' => 'Sergio Sánchez',
            ];
        } else {
            $tipoIncidencias[EstadoIncidencia::EN_CURSO->value][] = [
                'titulo' => 'Prueba 4',
                'codigo' => 'alc-1',
                'puntos' => null,
                'encargado' => null,
            ];

            $tipoIncidencias[EstadoIncidencia::QA->value][] = [
                'titulo' => 'Prueba 5',
                'codigo' => 'alc-2',
                'puntos' => null,
                'encargado' => 'Sergio Sánchez',
            ];

            $tipoIncidencias[EstadoIncidencia::QA->value][] = [
                'titulo' => 'Prueba 6',
                'codigo' => 'alc-3',
                'puntos' => 8,
                'encargado' => 'Sergio Sánchez',
            ];
        }
        
        return Inertia::render('Tablero', [
            'tablero' => $tablero,
            'tipoIncidencias' => $tipoIncidencias,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
