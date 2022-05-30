<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rubro;
use App\Http\Resources\Rubro as RubroResource;
use Image;

class RubroController extends Controller
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
        $rubros = Rubro::orderBy('nombre')->get();

        //Return collection of rubros as a resource
        // return RubroResource::collection($rubros);
        return response()->json($rubros->toArray());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexForPosts()
    {
        //Get rubros
        // $rubros = Rubro::paginate(15);
        $rubros = Rubro::where('nombre', '<>', 'Multirubro')->orderBy('nombre')->get();

        //Return collection of rubros as a resource
        // return RubroResource::collection($rubros);
        return response()->json($rubros->toArray());
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
        $rubro = new Rubro;

        $rubro->nombre = $request->input('nombre');
        $rubro->descripcion = $request->input('descripcion');

        //save image
        if($request->input('setFeatured')){
            $image = file_get_contents($request->input('setFeatured'));
            $filename = $request->input('nombre') . ".jpg";
            $location = public_path('assets/rubros/' . $filename);
            Image::make($image)->encode('jpg')->save($location);     
            //Image::make($image)->save($location);

            $rubro->rubroImage = $filename;
        } else { $rubro->rubroImage = 'default.jpg'; }

        if($rubro->save()){
            return response()->json($rubro->toArray());
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
        //Get rubro
        $rubro = Rubro::with('certificados')->findOrFail($id);

        //Return single rubro as a resource
        return response()->json($rubro->toArray());
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
        // Get rubro
        $rubro = Rubro::findOrFail($id);

        if($rubro->delete()){
            return new RubroResource($rubro);
        }
    }
}
