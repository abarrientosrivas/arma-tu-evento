<?php

namespace App\Http\Controllers;

use App\Solicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        $this->middleware('jwt.auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $solicitud = new Solicitud;

        $solicitud->title = $request->input('title');
        $solicitud->body = $request->input('body');
        $solicitud->reference = $request->input('reference');
        $solicitud->evento_id = $request->input('evento_id');
        $solicitud->post_id = $request->input('post_id');

        if($solicitud->save()){
            return response()->json($solicitud->toArray());
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
        // Get solicitud
        $solicitud = Solicitud::findOrFail($id);

        // Return single solicitud
        return response()->json($solicitud->toArray());
    }

    /**
     * return collection of solicitudes from proveedor
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fromProveedor($provId)
    {
        // Get solicitud
        $solicitudes = Solicitud::with('post')->with('evento')
                            ->join('posts','posts.id', '=', 'solicituds.post_id')
                            ->join('eventos','eventos.id', '=', 'solicituds.evento_id')
                            ->join('clientes','clientes.id', '=', 'eventos.cliente_id')
                            ->where('posts.proveedor_id', '=', $provId)
                            ->select('solicituds.*', 'clientes.nombre as cliNombre', 'clientes.apellido as cliApellido')
                            ->orderby('solicituds.created_at', 'DESC')
                            ->get();

        // Return single solicitud
        return response()->json($solicitudes->toArray());
    }

    /**
     * Reply to the solicitud
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function replySolicitud($id, $boolean)
    {
        // Get cliente
        $solicitud = Solicitud::findOrFail($id);

        if((string)$boolean == "true"){ 
            $solicitud->aceptada = true; $solicitud->rechazada = false;
        } else { $solicitud->aceptada = false; $solicitud->rechazada = true;}

        if($solicitud->save()){
            $reply = Solicitud::with('evento')->findOrFail($id);
            return response()->json($reply->toArray());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get cliente
        $solicitud = Solicitud::findOrFail($id);

        if($solicitud->delete()){
            return response()->json($solicitud->toArray());
        }
    }
}
