<?php

namespace App\Http\Controllers;

use App\Enums\EstadoIncidencia;
use App\Http\Requests\IncidenciaRequest;
use App\Models\Incidencia;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IncidenciaController extends Controller
{
    public function verificarProyecto(Proyecto $proyecto)
    {
        if($proyecto->creador_id != auth()->id()){
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Proyecto $proyecto)
    {
        $this->verificarProyecto($proyecto);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Proyecto $proyecto)
    {
        $this->verificarProyecto($proyecto);

        return Inertia::render('Incidencias/CrearEditar', [
            'proyecto' => $proyecto
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncidenciaRequest $request, Proyecto $proyecto)
    {
        $this->verificarProyecto($proyecto);

        $data = $request->validated();

        $data['proyecto_id'] = $proyecto->id;
        $data['informador_id'] = auth()->id();
        $data['estado'] = EstadoIncidencia::PENDIENTE->value;

        Incidencia::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Incidencia $incidencia, Proyecto $proyecto)
    {
        $this->verificarProyecto($proyecto);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidencia $incidencia, Proyecto $proyecto)
    {
        $this->verificarProyecto($proyecto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncidenciaRequest $request, Incidencia $incidencia, Proyecto $proyecto)
    {
        $this->verificarProyecto($proyecto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incidencia $incidencia, Proyecto $proyecto)
    {
        $this->verificarProyecto($proyecto);
    }
}
