<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//List clientes
Route::get('cliente', 'ClienteController@index');

//List single cliente
Route::get('cliente/{id}', 'ClienteController@show');

// Create cliente
Route::post('cliente', 'ClienteController@store');

// Update cliente
Route::put('cliente/{id}', 'ClienteController@store');

// Delete cliente
Route::delete('cliente/{id}', 'ClienteController@destroy');

///////////
// Route::post('cliente/login', 'ClienteController@loginCliente');
//////////


//List certificados
Route::get('certificado', 'CertificadoController@index');

//List single Certificados
Route::get('certificado/{id}', 'CertificadoController@show');

//////////////////////////// Buscar certificados por rubro
Route::get('certificado/rubro/{rubroId}', 'CertificadoController@certificadoPorRubro');
////////////////////////////

// Create Certificado
Route::post('certificado', 'CertificadoController@store');

// Update Certificado
Route::put('certificado/{id}', 'CertificadoController@store');

// Delete Certificado
Route::delete('certificado/{id}', 'CertificadoController@destroy');


//List certificados de proveedor
Route::get('certificadoProveedor', 'CertificadoProveedorController@index');

Route::get('certificadoProveedor/{id}', 'CertificadoProveedorController@show');

Route::post('certificadoProveedor', 'CertificadoProveedorController@store');

Route::put('certificadoProveedor/{id}', 'CertificadoProveedorController@store');

Route::delete('certificadoProveedor/{id}', 'CertificadoProveedorController@destroy');


//List reseñas
Route::get('resena', 'ResenaController@index');

//Single reseña
Route::get('resena/{id}', 'ResenaController@show');

Route::get('resena/posts', 'ResenaController@resenasPost');

// Create Reseña
Route::post('resena', 'ResenaController@store');

// Update Reseña
Route::put('resena/{id}', 'ResenaController@store');

// Delete Reseña
Route::delete('resena/{id}', 'ResenaController@destroy');


//List denuncia
Route::get('denuncia', 'DenunciaController@index');

//Single denuncia
Route::get('denuncia/{id}', 'DenunciaController@show');

// Create denuncia
Route::post('denuncia', 'DenunciaController@store');

// Update denuncia
Route::put('denuncia/{id}', 'DenunciaController@store');

// Delete denuncia
Route::delete('denuncia/{id}', 'DenunciaController@destroy');


//List proveedores
Route::get('proveedor', 'ProveedorController@index');

//List proveedores
Route::get('proveedor/rubro/{rubroId}', 'ProveedorController@proveedoresRubro');

//List single proveedor
Route::get('proveedor/{id}', 'ProveedorController@show');

// Update proveedor
Route::put('proveedor/{id}', 'ProveedorController@store');

// Create proveedor
Route::post('proveedor', 'ProveedorController@store');

// Delete proveedor
Route::delete('proveedor/{id}', 'ProveedorController@destroy');


// List posts
Route::get('post', 'PostController@index');

// List single proveedor
Route::get('post/{id}', 'PostController@show');

Route::get('post/resenas', 'PostController@promedioResenas');

// Update post
Route::put('post/{id}', 'PostController@store');

// Create post
Route::post('post', 'PostController@store');

// Delete post
Route::delete('post/{id}', 'PostController@destroy');

// Add image to post album
Route::post('postImage', 'PostImageController@addImage');

// Delete image from post album
Route::delete('postImage/{id}', 'PostImageController@deleteImage');


// List rubros
Route::get('rubro', 'RubroController@index');

// List rubros for post
Route::get('rubro/posts', 'RubroController@indexForPosts');

// Single rubro
Route::get('rubro/{id}', 'RubroController@show');

// Create new rubro
Route::post('rubro', 'RubroController@store');


// List tipos pagos
Route::get('tipoPago', 'TipoPagoController@index');

// Single tipo pago
Route::get('tipoPago/{id}', 'TipoPagoController@show');

// Update tipo pago
Route::put('tipoPago/{id}', 'TipoPagoController@store');

// Create tipo pago
Route::post('tipoPago', 'TipoPagoController@store');


// List pagos
Route::get('pago', 'PagoController@index');

// Single tipo pago
Route::get('pago/{id}', 'PagoController@show');

// Update tipo pago
Route::put('pago/{id}', 'PagoController@store');

// Create tipo pago
Route::post('pago', 'PagoController@store');


// Search posts
Route::get('search/{dateMillis}/{cantPersonas}', 'SearchController@search');

// Search posts from proveedor
Route::get('search/{provId}', 'SearchController@fromProveedor');


// Create evento
Route::post('evento', 'EventoController@store');

// Delete evento
Route::delete('evento/{id}', 'EventoController@destroy');

// List eventos from cliente
Route::get('evento/cliente/{id}', 'PostController@fromCliente');

// List eventos
Route::get('evento', 'EventoController@index');

// List single evento
Route::get('evento/{id}', 'PostController@show');


// Store a new notificacion
Route::post('notificacion', 'NotificacionController@store');

// List notificaciones of cliente
Route::get('notificacion/cliente/{id}', 'NotificacionController@getNotificacionsCli');

// List notificaciones of proveedor
Route::get('notificacion/proveedor/{id}', 'NotificacionController@getNotificacionsProv');

// Mark notificacion as read
Route::put('notificacion/{id}', 'NotificacionController@readNotificacion');


// store new solicitud
Route::post('solicitud', 'SolicitudController@store');

// get solicitudes from proveedor
Route::get('solicitud/{provId}', 'SolicitudController@fromProveedor');

// reply to solicitud
Route::put('solicitud/{id}/{boolean}', 'SolicitudController@replySolicitud');

// cancel solicitud
Route::delete('solicitud/{id}', 'SolicitudController@destroy');