<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Notificacion;
use App\Events\NotificacionSent;

class NotificacionController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get notificaciones
        $notificaciones = Notificacion::all();

        // Return collection of notificaciones
        return response()->json($notificaciones->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $notificacion = $request->isMethod('put') ? Notificacion::findOrFail($request->id) : new Notificacion;

        $notificacion = new Notificacion;

        $notificacion->title = $request->input('title');
        $notificacion->body = $request->input('body');
        $notificacion->reference = $request->input('reference');

        if($request->input('cliente_id')){ $notificacion->cliente_id = $request->input('cliente_id'); }
        if($request->input('proveedor_id')){ $notificacion->proveedor_id = $request->input('proveedor_id'); }

        if($notificacion->save()){
            broadcast(new NotificacionSent($notificacion))->toOthers();
            return response()->json($notificacion->toArray());
        }
    }

    public function getNotificacionsCli($id)
    {
        $notificaciones = Notificacion::where('cliente_id','=',$id)
                            ->orderBy('read')
                            ->orderBy('created_at', 'DESC')
                            ->get();

        return response()->json($notificaciones->toArray());
    }
    
    public function getNotificacionsProv($id)
    {
        $notificaciones = Notificacion::where('proveedor_id','=',$id)
                            ->orderBy('read')
                            ->orderBy('created_at', 'DESC')
                            ->get();

        return response()->json($notificaciones->toArray());
    }

    /**
     * Unreads a notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function readNotificacion($id)
    {
        $notificacion = Notificacion::findOrFail($id);

        $notificacion->read = true;

        $notificacion->save();

        return response()->json($notificacion->toArray());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get notificacion
        $notificacion = Notificacion::findOrFail($id);

        // Return single notificacion
        return response()->json($notificacion->toArray());
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
        $notificacion = Notificacion::findOrFail($id);

        if($notificacion->delete()){
            return response()->json($notificacion->toArray());
        }
    }
}
