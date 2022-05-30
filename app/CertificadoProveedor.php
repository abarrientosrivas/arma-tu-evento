<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Proveedor;
use App\Certificado;

class CertificadoProveedor extends Model
{
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function certificado()
    {
        return $this->belongsTo(Certificado::class);
    }
}
