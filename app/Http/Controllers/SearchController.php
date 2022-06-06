<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Post;

class SearchController extends Controller
{

       /**
     * Execute search using parameters given by the request.
     *
     * @param  int  $dateMillis
     * @param  int  $cantPersonas
     * @return \Illuminate\Http\Response
     */
    public function search(int $dateMillis,int $cantPersonas)
    {

        if($cantPersonas < 0 || $dateMillis < strtotime('yesterday')){
            abort(404);
        }

        $timestamp = ($dateMillis/1000) - 10800;
        // Get posts
        $posts = Post::whereNotIn('id',function($query) use ($timestamp){
                            $query->select('evento_post.post_id')
                                ->from('evento_post')
                                ->join('eventos', 'eventos.id', '=', 'evento_post.evento_id')
                                ->join('posts', 'posts.id', '=', 'evento_post.post_id')
                                ->where('eventos.fecha', '=', date("Y-m-d", $timestamp))
                                ->where('posts.simultaneo', '<>', true)
                                ->get();
                           })   
                        ->where(function ($query) use ($cantPersonas){
                            $query->where('maxPersonas', '>=', $cantPersonas)
                                  ->orWhereNull('maxPersonas');
                        })
                        ->with('proveedor')
                        ->with('rubro')
                        ->orderBy('posts.destacado', 'DESC')
                        ->orderBy('maxPersonas')    
                        ->orderBy('posts.created_at', 'DESC')
                        ->get();
       
        return response()->json($posts->toArray());
    }

      /**
     * Execute search and return events containing posts from proveedor
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fromProveedor($provId)
    {
        // Get posts
        $response = DB::table('posts')
                    ->join('proveedors', 'posts.proveedor_id', '=', 'proveedors.id')
                    ->join('evento_post', 'evento_post.post_id', '=', 'posts.id')
                    ->join('eventos', 'eventos.id', '=', 'evento_post.evento_id')
                    ->join('clientes', 'clientes.id', '=', 'eventos.cliente_id')
                    ->select('posts.*', 'eventos.fecha', 'clientes.nombre', 'clientes.apellido')
                    ->where('proveedors.id', '=', $provId)
                    ->orderBy('posts.created_at')
                    ->get();
       
        return response()->json($response->toArray());
    }

}
