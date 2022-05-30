<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Denuncia;
use App\Post;
use App\Cliente;
use App\Http\Resources\Denuncia as DenunciaResource;

class DenunciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $denuncias = Denuncia::all();
        // $denuncias = Denuncia::paginate(15);

        return response()->json($denuncias->toArray());
        // return DenunciaResource::collection($denuncias);
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
      $denuncia = $request->isMethod('put') ? Denuncia::findOrFail($request->id) : new Denuncia;

      //store in database
      $denuncia->titulo = $request->input('titulo');
      $denuncia->descripcion = $request->input('descripcion');
      $postId = $request->input('post_id');
      $clienteId = $request->input('cliente_id');

      $post = Post::findOrFail($postId);
      $cliente = Cliente::findOrFail($clienteId);

      if($post->denuncias()->save($denuncia) && $cliente->denuncias()->save($denuncia)) {
          return new DenunciaResource($denuncia);
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
        $denuncia =  Denuncia::with('post')->with('cliente')->findOrFail($id);

        return response()->json($denuncia->toArray());
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
      // Get denuncia
      $denuncia = Denuncia::findOrFail($id);

      if($denuncia->delete()){
          return new DenunciaResource($denuncia);
      }
    }
}
