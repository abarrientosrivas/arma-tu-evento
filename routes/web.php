<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

// Route::get('/', function () {
//     return view('index');
// });

// Route::resource('clientes','ClienteController');

// Route::resource('certificados', 'CertificadoController');
/*
Route::get('/userimage/{filename}', [
    'uses' => 'ClienteController@getUserImage',
    'as' => 'account.image'
]);
*/
// Route::resource('resenas','ResenaController');

//Route::resource('proveedores','ProveedorController');

Route::post('todopago', 'PagoController@pagarConTodopago');


// Route::get('cliente/profile', ['uses' => 'ClienteController@getProfile', 'as' => 'cliente.profile']);

Route::put('cliente/profile', 'ClienteController@addProfileImage');
Route::put('proveedor/profile', 'ProveedorController@addProfileImage');

Route::post('certificado/add', 'CertificadoController@store');
Route::put('certificado/add', 'CertificadoController@store');

Route::get('post/resenas', 'PostController@promedioResenas');
Route::get('post/promedio/{id}', 'PostController@promedioPost');

// Auth routes
Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
Route::post('authenticate/proveedor', 'AuthenticateController@authenticateProveedor');
Route::post('authenticate/cliente', 'AuthenticateController@authenticateCliente');
Route::post('authenticate/admin', 'AuthenticateController@authenticateAdmin');

// Chat routes
Route::get('conversations/proveedor/{id}', 'ChatsController@getConversationsProveedor');
Route::get('conversations/cliente/{id}', 'ChatsController@getConversationsCliente');
Route::post('conversations', 'ChatsController@newConversation');
Route::get('conversations/{id}', 'ChatsController@getConversation');
Route::post('conversations/message/{id}', 'ChatsController@saveMessage');
Route::get('conversations/message/{id}', 'ChatsController@getMessage');
Route::get('conversations/find/{provId}/{cliId}', 'ChatsController@findConversation');

// File upload routes
Route::post('upload', 'ChatsController@fileUpload');
