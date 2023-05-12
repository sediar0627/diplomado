<?php

namespace App\Http\Controllers;

use App\Http\Requests\EpicaRequest;
use App\Models\Epica;
use App\Models\Proyecto;
use Illuminate\Http\Request;

class EpicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Proyecto $proyecto)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Proyecto $proyecto)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EpicaRequest $request, Proyecto $proyecto)
    {
        $data = $request->validated();
        $data['proyecto_id'] = $proyecto->id;

        Epica::create($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyecto $proyecto, Epica $epica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyecto $proyecto, Epica $epica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EpicaRequest $request, Proyecto $proyecto, Epica $epica)
    {
        $epica->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proyecto $proyecto, Epica $epica)
    {
        $epica->incidencias()->update(['epica_id' => null]);
        $epica->delete();
    }
}
