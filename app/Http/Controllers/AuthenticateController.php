<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuthExceptions\JWTException;
use JWTAuth;
use Config;
use App\Proveedor;

class AuthenticateController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['authenticate', 'authenticateProveedor', 'authenticateCliente', 'authenticateAdmin',]]);
    }
    
    // public function getAuthenticatedUser()
    // {
	// 	Config::set('jwt.user', 'App\Proveedor'); 
    //     Config::set('auth.providers.users.model', \App\Proveedor::class);
    //     Config::set('auth.providers.users.table', 'proveedors');
    // try {

    //     if (! $user = JWTAuth::parseToken()->authenticate()) {
    //         return response()->json(['user_not_found'], 404);
    //     }

    // } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

    //     return response()->json(['token_expired'], $e->getStatusCode());

    // } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

    //     return response()->json(['token_invalid'], $e->getStatusCode());

    // } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

    //     return response()->json(['token_absent'], $e->getStatusCode());

    // }

    // // the token is valid and we have found the user via the sub claim
    // return response()->json(compact('proveedor'));
    // }
    
    public function index()
    {
        // Retrieve all the users in the database and return them
        $users = Proveedor::all();
        return $users;
    }  

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = JWTAuth::toUser($token);
        // if no errors are encountered we can return a JWT with user
        return response()->json(compact('token', 'user'));
    }

    public function authenticateProveedor(Request $request)
    {
		Config::set('jwt.user', 'App\Proveedor'); 
        Config::set('auth.providers.users.model', \App\Proveedor::class);
        Config::set('auth.providers.users.table', 'proveedors');
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = JWTAuth::toUser($token);
        $user->rol = 'proveedor';
        // if no errors are encountered we can return a JWT with user
        return response()->json(compact('token', 'user'));
    }

    public function authenticateCliente(Request $request)
    {
		Config::set('jwt.user', 'App\Cliente'); 
        Config::set('auth.providers.users.model', \App\Cliente::class);
        Config::set('auth.providers.users.table', 'clientes');
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = JWTAuth::toUser($token);
        $user->rol = 'cliente';
        // if no errors are encountered we can return a JWT with user
        return response()->json(compact('token', 'user'));
    }

    public function authenticateAdmin(Request $request)
    {
		Config::set('jwt.user', 'App\Admin'); 
        Config::set('auth.providers.users.model', \App\Admin::class);
        Config::set('auth.providers.users.table', 'admins');
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = JWTAuth::toUser($token);
        $user->rol = 'admin';
        // if no errors are encountered we can return a JWT with user
        return response()->json(compact('token', 'user'));
    }
}