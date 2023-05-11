<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnviarInvitacionProyectoRequest;
use App\Http\Requests\ProyectoRequest;
use App\Mail\InvitacionProyecto;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Proyectos/Listado', [
            'proyectos' => auth()->user()->proyectos(),
            'usuario_logueado_id' => auth()->id()
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
        if(!$proyecto->sePuedeEliminar()){
            session()->flash('error', "El proyecto {$proyecto->descripcion_modelo} no se puede eliminar.");
        } else {
            session()->flash('success', 'Proyecto eliminado correctamente.');
            $proyecto->delete();
        }

        return $this->index();
    }

    public function enviarInvitacion(EnviarInvitacionProyectoRequest $request, Proyecto $proyecto)
    {
        if($proyecto->creador_id != auth()->id()){
            abort(403);
        }

        $correo = $request->validated()['correo'];
        $usuarioAInvitar = User::where('email', $correo)->first();

        Mail::to([$correo])->send(new InvitacionProyecto($proyecto, $usuarioAInvitar));
    }

    public function aceptarInvitacion(Request $request)
    {
        $informacion = null;

        try {
            $informacion = decrypt($request->route('token'));
            $informacion = json_decode($informacion, true);
        } catch (\Throwable $th) {
            abort(404);
        }

        if($informacion['usuario_id'] != auth()->id()){
            abort(403);
        }

        $proyecto = Proyecto::find($informacion['proyecto_id']);

        $proyecto->usuariosInvitados()->sync([
            'user_id' => $informacion['usuario_id']
        ]);

        return to_route('proyectos.index')->with('success', "Bienvenido al equipo de {$proyecto->nombre}.");
    }
}
