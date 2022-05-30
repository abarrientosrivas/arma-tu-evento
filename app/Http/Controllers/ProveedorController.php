<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Proveedor;
use App\Post;
use App\Http\Resources\Proveedor as ProveedorResource;
use Image;

class ProveedorController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get clientes
        // $proveedores = Proveedor::paginate(15);
        $proveedores = Proveedor::all();

        // Return collection of clients as a resource
        // return ProveedorResource::collection($proveedores);
        return response()->json($proveedores->toArray());
    }

    /**
     * Display a listing of the resource from a specific rubro
     *
     * @return \Illuminate\Http\Response
     */
    public function proveedoresRubro($rubroName)
    {
        $rubroNombre = (string) urldecode($rubroName);

        $proveedores = Proveedor::join('rubros','rubros.id','=','proveedors.rubro_id')
                                ->where('rubros.nombre','=',$rubroNombre)
                                ->select('proveedors.*')
                                ->orderBy('proveedors.destacado_rubro', 'DESC')
                                ->get();

        // Return collection of proveedores as a resource
        return response()->json($proveedores->toArray());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('proveedor-home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get cliente
        $proveedor = Proveedor::with(array('posts' => function($query) {
            $query->with('resenas')->with('rubro')->orderBy('created_at', 'DESC');
        }))->with('rubro')->with('certificados')->with('tipopago')->findOrFail($id);

        // Return single client as resource
        return response()->json($proveedor->toArray());
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proveedor = $request->isMethod('put') ? Proveedor::findOrFail
        ($request->id) : new Proveedor;

        //store in database
        $proveedor->nombre = $request->input('nombre');
        $proveedor->cuit = $request->input('cuit');
        $proveedor->email = $request->input('email');
        // $proveedor->password = bcrypt($request->input('password'));
        $proveedor->descripcion = $request->input('descripcion');
        $proveedor->rubro_id = $request->input('rubro_id');
        $proveedor->tipo_susc_id = $request->input('tipo_susc_id');
        $proveedor->pago = $request->input('pago');
        $proveedor->fin_susc = $request->input('fin_susc');
        $proveedor->destacado_rubro = $request->input('destacado_rubro');

        //save image
        if($request->hasFile('profile_image')){
            $image = $request->file('profile_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/' . $filename);
            Image::make($image)->resize(400,400)->save($location);

            $proveedor->image = $filename;
        }

        // if($request->input('profileImage') && !$request->input('tipo_susc_id') && !$request->input('pago') && !$request->input('fin_susc') && !$request->input('destacado_rubro'))
        // {
        //   $proveedor = Proveedor::findOrFail($request->id);
        //   // $cliente->profileImage = $request->input('cliente_id');
        //   // var_dump($request->input('profileImage'));
        //   $image = file_get_contents($request->input('profileImage'));
        //   $filename = date("Y-m-d_") . round(microtime(true) * 1000) . "-" . $proveedor->id . ".jpg";
        //   $location = public_path('assets/prov-profiles/' . $filename);
        //   Image::make($image)->encode('jpg')->save($location);

        //   $proveedor->profileImage = $filename;
        //   // $cliente->save();
        // }

        if($proveedor->save()){
            return response()->json($proveedor->toArray());
        }
    }

    public function addProfileImage(Request $request)
    {
      if($request->input('profileImage'))
      {
        $proveedor = Proveedor::findOrFail($request->input('proveedor_id'));
          // $cliente->profileImage = $request->input('cliente_id');
          // var_dump($request->input('profileImage'));
          $image = file_get_contents($request->input('profileImage'));
          $filename = date("Y-m-d_") . round(microtime(true) * 1000) . "-" . $request->input('proveedor_id') . ".jpg";
          $location = public_path('assets/prov-profiles/' . $filename);
          Image::make($image)->encode('jpg')->save($location);

          $proveedor->profileImage = $filename;
          $proveedor->save();
      }
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
        // Get proveedor
        $proveedor = Proveedor::findOrFail($id);

        if($proveedor->delete()){
            return response()->json($proveedor->toArray());
        }
    }
}
