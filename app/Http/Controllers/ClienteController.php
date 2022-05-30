<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Cliente;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Resources\Cliente as ClienteResource;
use Session;
use Image;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get clientes
        //$clientes = Cliente::paginate(15);
        $clientes = Cliente::all();

        // Return collection of clients as a resource
        //return ClienteResource::collection($clientes);
        return response()->json($clientes->toArray());
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
        $cliente = $request->isMethod('put') ? Cliente::findOrFail
        ($request->id) : new Cliente;

        if($request->isMethod('post')){ 
            //validate
            $this->validate($request, array(
                'email' => 'unique:clientes',
                'password' => 'min:4'
            ));
            $cliente->password = bcrypt($request->input('password')); 
            $cliente->email = $request->input('email');
        }

        $cliente->nombre = $request->input('nombre');
        $cliente->apellido = $request->input('apellido');
        $cliente->bio = $request->input('bio');
        if($request->input('password')){
            $cliente->password = bcrypt($request->input('password')); 
        }

        // Session::flash('success', 'Cliente agregado correctamente');
        // if($request->input('profileImage')){
        //   $image = file_get_contents($request->input('profileImage'));
        //   $filename = date("Y-m-d_") . round(microtime(true) * 1000) . "-" . $request->input('cliente_id'). ".jpg";
        //   $location = public_path('assets/cliente-profile-image/' . $filename);
        //   Image::make($image)->encode('jpg')->save($location);
        //
        //   $cliente->profileImage = $filename;
        // }
        if($cliente->save()){
            return new ClienteResource($cliente);
        }
    }

    public function addProfileImage(Request $request)
    {
      if($request->input('profileImage'))
      {
        $cliente = Cliente::findOrFail($request->input('cliente_id'));
        // $cliente->profileImage = $request->input('cliente_id');
        // var_dump($request->input('profileImage'));
        $image = file_get_contents($request->input('profileImage'));
        $filename = date("Y-m-d_") . round(microtime(true) * 1000) . "-" . $request->input('cliente_id') . ".jpg";
        $location = public_path('assets/cliente-profile-image/' . $filename);
        Image::make($image)->encode('jpg')->save($location);

        $cliente->profileImage = $filename;
        $cliente->save();
      }
    }

    public function loginCliente(Request $request)
    {
      $credentials = [
        'email' => $request->input('email'),
        'password' => $request->input('password'),
      ];

      if (Auth::attempt($credentials)) {
        // return redirect()->route('cliente.profile');
        return response(Auth::cliente(), 201);
      }
      // return redirect()->back();
      return response('Datos incorrectos', 403);
    }

    // public function getProfile()
    // {
    //   return view('cliente.profile');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get cliente
        $cliente = Cliente::with(array('eventos' => function($query) {
            $query->with('posts');
        }))->with('denuncias')->with('resenas')->findOrFail($id);
        // Return single client as resource
        return response()->json($cliente->toArray());
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
        $cliente = Cliente::findOrFail($id);

        if($cliente->delete()){
            return new ClienteResource($cliente);
        }
    }
/*
    public function postSaveAccount(Request $request)
    {
        $cliente = $request['nombre'];
        $file = $request->file('image');
        $filename = $request['nombre'] . '-' . $cliente->id . '.jpg';
        if($file){
            Storage::disk('local')->put($filename, File::get($file));
        }

    }

    public function getUserImage($filename)
    {
        $file = Storage::disk('local')->get($filename);
        return new Response($file,200);
    }
*/
}
