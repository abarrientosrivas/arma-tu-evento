<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoPago;
use App\Http\Resources\TipoPago as TipoPagoResource;

class TipoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = TipoPago::orderBy('id')->get();

        return response()->json($tipos->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipo = $request->isMethod('put') ? TipoPago::findOrFail
        ($request->id) : new TipoPago;

        $tipo->id = $request->input('id');
        $tipo->periodo = $request->input('periodo');
        $tipo->precio = $request->input('precio');

        if($tipo->save()){
            return new TipoPagoResource($tipo);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Get tipo
        $tipo = TipoPago::findOrFail($id);

        //Return single tipo as a resource
        return response()->json($tipo->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // Get tipo
         $tipo = TipoPago::findOrFail($id);

         if($tipo->delete()){
             return new TipoPagoResource($tipo);
         }
    }
}
