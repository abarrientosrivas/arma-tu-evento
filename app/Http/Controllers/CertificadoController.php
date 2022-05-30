<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Certificado;
use App\Proveedor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Resources\Certificado as CertificadoResource;


class CertificadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get certificados
        // $certificados = Certificado::paginate(15);
        $certificados = Certificado::all();

        //Return collection of certificados as a resource
        // return CertificadoResource::collection($certificados);
        return response()->json($certificados->toArray());
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
        $certificado = $request->isMethod('put') ? Certificado::findOrFail
        ($request->id) : new Certificado;

        $certificado->id = $request->input('id');
        $certificado->titulo = $request->input('titulo');
        $certificado->descripcion = $request->input('descripcion');
        // $certificado->fecha = $request->input('fecha');
        $certificado->obligatorio = $request->input('obligatorio');
        // $provId = $request->input('proveedor_id');
        // $certificado->rubro_id = $request->input('rubro_id');


        // $proveedor = Proveedor::findOrFail($provId);

        if($certificado->save()){
            $certificado->rubros()->sync($request->rubros);
            return new CertificadoResource($certificado);
        }
        // if($proveedor->certificados()->save($certificado)){
        //     return response()->json($certificado->toArray());
        // }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Get certificado
        $certificado = Certificado::with('rubros')->findOrFail($id);

        //Return single certificado as a resource
        // return new CertificadoResource($certificado);
        return response()->json($certificado->toArray());
    }

    public function certificadoPorRubro($rubroId)
    {
        // $certificados = Certificado::where('')
        // $response = DB::table('certificados')
        //                 ->join('rubros', 'rubros.id', '=', 'certificados.rubro_id')
        //                 ->select('certificados.*')
        //                 ->where('certificados.rubro_id', '=', $rubroId)
        //                 ->get();
        $response = DB::table('certificados')
                        ->join('certificado_rubro', 'certificado_rubro.certificado_id', '=', 'certificados.id')
                        ->select('certificados.*')
                        ->where('certificado_rubro.rubro_id', '=', $rubroId)
                        ->get();
        
        return response()->json($response->toArray());
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
        // Get certificado
        $certificado = Certificado::findOrFail($id);
        $certificado->rubros()->detach();

        if($certificado->delete()){
            return new CertificadoResource($certificado);
        }
    }
}
