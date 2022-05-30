<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use App\Cliente;
use App\Post;
use App\Solicitud;

class EventoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get rubros
        // $rubros = Rubro::paginate(15);
        $eventos = Evento::orderBy('fecha')->get();

        //Return collection of rubros as a resource
        // return RubroResource::collection($rubros);
        return response()->json($eventos->toArray());
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function fromCliente($id)
    {
        // Get eventos
        $eventos = Evento::with('posts')->where('cliente_id','=',$id)->orderBy('created_at', 'DESC')->get();

        // Return collection of eventos as a resource
        return response()->json($eventos->toArray());
    }

    public function show($id)
    {
      // Get cliente
        $evento = Evento::with('posts')->with('cliente')->findOrFail($id);

      // Return single evento as resource
        return response()->json($evento->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $evento = $request->isMethod('put') ? Evento::findOrFail($request->id) : new Evento;

        //store in database
        $evento->cantPersonas = $request->input('cantPersonas');
        $evento->fecha = $request->input('fecha');

        $cliente = Cliente::findOrFail($request->input('cliente_id'));
        $cliente->eventos()->save($evento);

        foreach ($request->input('posts') as $post) {
            $postInstance = Post::findOrFail($post['id']);
            $evento->posts()->save($postInstance);
            $solicitud = new Solicitud;
            $solicitud->post_id = $postInstance->id;
            $evento->solicituds()->save($solicitud);
        }

        return response()->json($evento->toArray());

    }

       /**
     * Remove the specified resource from storage.
     * Currently soft deleting
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get post
        $evento = Evento::findOrFail($id);

        if($evento->delete()){
            return response()->json($evento->toArray());
        }
    }
}
