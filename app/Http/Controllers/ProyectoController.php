<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProyectoRequest;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Proyectos/Listado', [
            'proyectos' => Proyecto::where('creador_id', auth()->id())->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Proyectos/CrearEditar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProyectoRequest $request)
    {
        $data = $request->validated();
        
        $data['creador_id'] = auth()->id();

        Proyecto::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyecto $proyecto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyecto $proyecto)
    {
        if($proyecto->creador_id != auth()->id()){
            abort(403);
        }

        return Inertia::render('Proyectos/CrearEditar', [
            'proyecto' => $proyecto
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProyectoRequest $request, Proyecto $proyecto)
    {
        if($proyecto->creador_id != auth()->id()){
            abort(403);
        }

        $proyecto->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyecto $proyecto)
    {
        if(!$proyecto->puedeEliminar()){
            session()->flash('error', "El proyecto {$proyecto->descripcion_modelo} no se puede eliminar.");
        } else {
            session()->flash('success', 'Proyecto eliminado correctamente.');
            $proyecto->delete();
        }

        return $this->index();
    }
}
