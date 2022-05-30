<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use TodoPago\Sdk;
use App\Pago;
use App\Proveedor;
use App\Http\Resources\Pago as PagoResource;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
  public function pagarConTodopago(Request $request){
    //común a todas los métodos
    $http_header = array('Authorization'=>'PRISMA A793D307441615AF6AAAD7497A75DE59',
    'user_agent' => 'PHPSoapClient');
    $mode = "test";

    //datos constantes
    define('CURRENCYCODE', 032);
    define('MERCHANT', 2159);
    define('ENCODINGMETHOD', 'XML');
    define('SECURITY', 'A793D307441615AF6AAAD7497A75DE59');

    //id de la operacion
    $operationid = rand(0, 99999999);

    $postId = $request->get('postId');

    $urlOK = "http://armatuevento.test/#!/exito";

    if($request->get('productName') == 'pagar post') {
      $urlOK = "http://armatuevento.test/#!/exito-post/" . $postId;
    } 
    if($request->get('productName') == 'pagar rubro') {
      $urlOK = "http://armatuevento.test/#!/exito-rubro";
    }
    

    //opciones para el método sendAuthorizeRequest (datos propios del comercio)
    $optionsSAR_comercio = array (
	     'Security'=> SECURITY,
	     'EncodingMethod'=> ENCODINGMETHOD,
	     'Merchant'=> MERCHANT,
	     // 'URL_OK'=>"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].str_replace ($_SERVER['DOCUMENT_ROOT'], '', dirname($_SERVER['SCRIPT_FILENAME']))."/exito.php?operationid=$operationid",
       'URL_OK'=> $urlOK,
	     // 'URL_ERROR'=>"http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].str_replace ($_SERVER['DOCUMENT_ROOT'], '', dirname($_SERVER['SCRIPT_FILENAME']))."/error.php?operationid=$operationid"
       'URL_ERROR'=>"http://armatuevento.test/#!/error"
    );

    // + opciones para el método sendAuthorizeRequest (datos propios de la operación)
    // $optionsSAR_operacion = $_POST;
    // $optionsSAR_operacion['MERCHANT'] = MERCHANT;
    $optionsSAR_operacion = array (
     'CSBTCITY'=>'Villa General Belgrano', //Ciudad de facturación, REQUERIDO.
     'CSBTCOUNTRY'=>'AR', //País de facturación. REQUERIDO. Código ISO.
     'CSBTCUSTOMERID'=>'453458', //Identificador del usuario al que se le emite la factura. REQUERIDO. No puede contener un correo electrónico.
     'CSBTIPADDRESS'=>'192.0.0.4', //IP de la PC del comprador. REQUERIDO.
     // 'CSBTEMAIL'=>'decidir@hotmail.com', //Mail del usuario al que se le emite la factura. REQUERIDO.
     // 'CSBTFIRSTNAME'=>'Juan' ,//Nombre del usuario al que se le emite la factura. REQUERIDO.
     // 'CSBTLASTNAME'=>'Perez', //Apellido del usuario al que se le emite la factura. REQUERIDO.
     'CSBTPHONENUMBER'=>'541160913988', //Teléfono del usuario al que se le emite la factura. No utilizar guiones, puntos o espacios. Incluir código de país. REQUERIDO.
     'CSBTPOSTALCODE'=>' C1010AAP', //Código Postal de la dirección de facturación. REQUERIDO.
     'CSBTSTATE'=>'B', //Provincia de la dirección de facturación. REQUERIDO. Ver tabla anexa de provincias.
     'CSBTSTREET1'=>'Cerrito 740', //Domicilio de facturación (calle y nro). REQUERIDO.
     'CSPTCURRENCY'=>'ARS', //Moneda. REQUERIDO.
     'CSPTGRANDTOTALAMOUNT'=>'125.38', //Con decimales opcional usando el punto como separador de decimales. No se permiten comas, ni como separador de miles ni como separador de decimales. REQUERIDO. (Ejemplos:$125,38-> 125.38 $12-> 12 o 12.00)
     'CSSTCITY'=>'rosario', //Ciudad de envío de la orden. REQUERIDO.
     'CSSTCOUNTRY'=>'AR', //País de envío de la orden. REQUERIDO.
     'CSSTEMAIL'=>'jose@gmail.com', //Mail del destinatario, REQUERIDO.
     'CSSTFIRSTNAME'=>'Jose', //Nombre del destinatario. REQUERIDO.
     'CSSTLASTNAME'=>'Perez', //Apellido del destinatario. REQUERIDO.
     'CSSTPHONENUMBER'=>'541155893737', //Número de teléfono del destinatario. REQUERIDO.
     'CSSTPOSTALCODE'=>'1414', //Código postal del domicilio de envío. REQUERIDO.
     'CSSTSTATE'=>'D', //Provincia de envío. REQUERIDO. Son de 1 caracter
     'CSSTSTREET1'=>'San Martín 123', //Domicilio de envío. REQUERIDO.
     //Retail: datos a enviar por cada producto, los valores deben estar separados con #:
     'CSITPRODUCTCODE'=>'electronic_software', //Código de producto. REQUERIDO. Valores posibles(adult_content;coupon;default;electronic_good;electronic_software;gift_certificate;handling_only;service;shipping_and_handling;shipping_only;subscription)
     'CSITPRODUCTDESCRIPTION'=>'SUSCRIPCIÓN A ARMÁ TU EVENTO', //Descripción del producto. REQUERIDO.
     'CSITPRODUCTNAME'=>'SUSCRIPCIÓN A ARMÁ TU EVENTO', //Nombre del producto. REQUERIDO.
     'CSITPRODUCTSKU'=>'LEVJNSL36GN', //Código identificador del producto. REQUERIDO.
     'CSITTOTALAMOUNT'=>'1254.40', //CSITTOTALAMOUNT=CSITUNITPRICE*CSITQUANTITY "999999[.CC]" Con decimales opcional usando el punto como separador de decimales. No se permiten comas, ni como separador de miles ni como separador de decimales. REQUERIDO.
     'CSITQUANTITY'=>'1', //Cantidad del producto. REQUERIDO.
     'CSITUNITPRICE'=>'80.00', //Formato Idem CSITTOTALAMOUNT. REQUERIDO.
     // 'AMOUNT'=>$request->get('monto'),
	  );
    $optionsSAR_operacion['MERCHANT'] = MERCHANT;
    // $optionsSAR_operacion['AMOUNT'] = 64.00;
    $optionsSAR_operacion['AMOUNT'] = $request->get('monto');
    $optionsSAR_operacion['CSBTFIRSTNAME'] = $request->get('nombre');
    $optionsSAR_operacion['CSBTLASTNAME'] = $request->get('apellido');
    $optionsSAR_operacion['CSBTEMAIL'] = $request->get('mail');
    // $optionsSAR_operacion['AMOUNT'] = $_POST['monto'];
    $optionsSAR_operacion['CURRENCYCODE'] = CURRENCYCODE;
    $optionsSAR_operacion['OPERATIONID'] = $operationid;
    // var_dump($optionsSAR_operacion);

    //creo instancia de la clase TodoPago
    $connector = new Sdk($http_header, $mode);
    $rta = $connector->sendAuthorizeRequest($optionsSAR_comercio, $optionsSAR_operacion);

    // opciones para el método getStatus
    // $optionsGS = array('MERCHANT'=>MERCHANT, 'OPERATIONID'=>$operationid);
    // $status = $connector->getStatus($optionsGS);

    // echo "<h3>var_dump de la respuesta de Send Authorize Request</h3>";
    // var_dump($status);
    
    if($rta['StatusCode'] != -1) {
	        var_dump($rta);
    } else {
	      setcookie('RequestKey',$rta["RequestKey"],  time() + (86400 * 30), "/");
	      header("Location: ".$rta["URL_Request"]);
    }

  } // end function pagar con todo pago

  
  public function index()
  {
    $response = DB::table('pagos')
                    ->join('proveedors', 'proveedors.id', '=', 'pagos.proveedor_id')
                    ->select('pagos.*', 'proveedors.nombre')
                    ->get();
    
    return response()->json($response->toArray());

    // $pagos = Pago::with('proveedor')->get();

    // return response()->json($pagos->toArray());
  }

  public function show($id)
  {
    // Get pago
    $pago = Pago::with('proveedor')->findOrFail($id);

    // Return single client as resource
    // return new PagoResource($pago);
    return response()->json($pago->toArray());
  }

  public function store(Request $request)
  {
      $pago = $request->isMethod('put') ? Pago::findOrFail($request->id) : new Pago;

      //store in database
      $pago->monto = $request->input('monto');
      $pago->tipo = $request->input('tipo');
      $pago->fecha_pago = $request->input('fecha_pago');
      $pago->fecha_fin = $request->input('fecha_fin');
      $pago->facturado = $request->input('facturado');
      $provId = $request->input('proveedor_id');

      $proveedor = Proveedor::findOrFail($provId);

      if($proveedor->pagos()->save($pago)){
          return response()->json($pago->toArray());
      }

  }

  public function destroy($id)
  {
      // Get pago
      $pago = Pago::findOrFail($id);

      if($pago->delete()){
          return response()->json($pago->toArray());
      }
  }

} // end class
