<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;
use App\Proveedor;
use App\PostImage;
use App\Http\Requests;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\Proveedor as ProveedorResource;
use Image;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        // Get clientes
        $posts = Post::with('rubro')->orderBy('updated_at', 'DESC')->get();

        // Return collection of clients as a resource
        // return PostResource::collection($posts);
        return response()->json($posts->toArray());
    }

    public function show($id)
    {
      // Get cliente
        $post = Post::with('proveedor')->with('rubro')->with('resenas')->with('postImages')->findOrFail($id);

      // Return single client as resource
    //   return new PostResource($post);
        return response()->json($post->toArray());
    }

    public function promedioResenas()
    {
        $posts = DB::table('posts')
                    ->leftJoin('resenas', 'posts.id', '=', 'resenas.post_id')
                    ->select('posts.*', DB::raw('AVG(calificacion) as promedio'))
                    // ->whereNull('posts.id')
                    ->groupBy('resenas.post_id')
                    // ->orderBy('posts.updated_at', 'DESC')
                    ->get();
        // var_dump($posts);
        return response()->json($posts->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = $request->isMethod('put') ? Post::findOrFail($request->id) : new Post;

        //store in database
        $post->titulo = $request->input('titulo');
        $post->cuerpo = $request->input('cuerpo');
        $post->simultaneo = $request->input('simultaneo');
        $post->maxPersonas = $request->input('maxPersonas');
        $provId = $request->input('proveedor_id');
        $post->rubro_id = $request->input('rubro_id');
        $post->destacado = $request->input('destacado');
        $post->promedio = $request->input('promedio');
        // $post->promedio = promedioPost($request->id);

        $proveedor = Proveedor::findOrFail($provId);

        //save image
        if($request->input('setFeatured')){
            $image = file_get_contents($request->input('setFeatured'));
            $filename = date("Y-m-d_") . round(microtime(true) * 1000) . "-" . $request->input('proveedor_id') . ".jpg";
            $location = public_path('assets/post-images/' . $filename);
            Image::make($image)->encode('jpg')->save($location);     
            //Image::make($image)->save($location);

            $post->featuredImage = $filename;
        } else { $post->featuredImage = 'default.jpg'; }

        if($proveedor->posts()->save($post)){
            return response()->json($post->toArray());
        }

    }

    public function promedioPost($id)
    {
        // $promedio = DB::table('posts')
        //                 ->leftJoin('resenas', 'posts.id', '=', 'resenas.post_id')
        //                 // ->select(DB::raw('AVG(calificacion)'))
        //                 ->select(avg('calificacion'))
        //                 ->where('posts.id', '=', $id)
        //                 ->get();
        $promedio = DB::table('posts')
                        ->leftJoin('resenas', 'posts.id', '=', 'resenas.post_id')
                        ->where('posts.id', '=', $id)
                        ->avg('calificacion');
        // var_dump($promedio);
        // return response()->json($promedio);
        return json_encode($promedio);
        // return json_encode($promedio);
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
        $post = Post::findOrFail($id);

        if($post->delete()){
            return response()->json($post->toArray());
        }
    }
}
