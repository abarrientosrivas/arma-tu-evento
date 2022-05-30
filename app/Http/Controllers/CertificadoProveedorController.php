<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\CertificadoProveedor;
use App\Http\Resources\CertificadoProveedor as CertificadoProveedorResource;
use App\Certificado;
use App\Proveedor;

class CertificadoProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certificados = CertificadoProveedor::all();

        return response()->json($certificados->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $certificado = $request->isMethod('put') ? CertificadoProveedor::findOrFail
        ($request->id) : new CertificadoProveedor;

        $certificado->id = $request->input('id');
        // $certificado->descripcion = $request->input('descripcion');
        $certificado->fecha = $request->input('fecha');
        // $certificado->obligatorio = $request->input('obligatorio');
        $provId = $request->input('proveedor_id');
        $certId = $request->input('certificado_id');
        $certificado->certificado_id = $request->input('certificado_id');

        $proveedor = Proveedor::findOrFail($provId);
        $certificadoTipo = Certificado::findOrFail($certId);

        if($proveedor->certificados()->save($certificado)){
            return response()->json($certificado->toArray());
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
        //Get certificado
        $certificado = CertificadoProveedor::with('proveedor')->with('certificado')->findOrFail($id);
        
        //Return single certificado as a resource
        return response()->json($certificado->toArray());
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
        $certificado = CertificadoProveedor::findOrFail($id);
        
        if($certificado->delete()){
            return new CertificadoProveedorResource($certificado);
        }
    }
}
