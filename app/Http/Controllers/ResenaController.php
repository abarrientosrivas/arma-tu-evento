<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Resena;
use App\Post;
use App\Cliente;
use App\Http\Resources\Resena as ResenaResource;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class ResenaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = DB::table('resenas')
                        ->join('clientes', 'clientes.id', '=', 'resenas.cliente_id')
                        ->select('resenas.*', 'clientes.nombre', 'clientes.apellido')
                        ->get();

        return response()->json($response->toArray());


        // // Get reseñas
        // $resenas = Resena::orderBy('id','DESC')->get();

        // // Return collection of reseñas as a resource
        // //return ResenaResource::collection($resenas);
        // return response()->json($resenas->toArray());
    }

    public function resenasPost()
    {
        $resenas = DB::table('resenas')
                        ->join('clientes', 'clientes.id', '=', 'resenas.cliente_id')
                        ->select('resenas.*', 'clientes.nombre')
                        ->get();

        return response()->json($resenas->toArray());
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
      $resena = $request->isMethod('put') ? Resena::findOrFail($request->id) : new Resena;

      //store in database
      $resena->titulo = $request->input('titulo');
      $resena->cuerpo = $request->input('cuerpo');
      $resena->calificacion = $request->input('calificacion');
      $postId = $request->input('post_id');
      $clienteId = $request->input('cliente_id');

      $post = Post::findOrFail($postId);
      $cliente = Cliente::findOrFail($clienteId);

      if($post->resenas()->save($resena) && $cliente->resenas()->save($resena)){
          return new ResenaResource($resena);
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
        // Get reseña
        $resena = Resena::with('post')->with('cliente')->findOrFail($id);
        // $resena = Resena::findOrFail($id);

        //Return single reseña as a resource
        return response()->json($resena->toArray());

        // return new ResenaResource($resena);

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
      // Get post
      $resena = Resena::findOrFail($id);

      if($resena->delete()){
          return new ResenaResource($resena);
      }
    }
}
