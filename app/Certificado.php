<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Proveedor;
use App\CertificadoProveedor;
use App\Rubro;
//\Carbon\Carbon::setToStringFormat('dd/MM/yyyy');

class Certificado extends Model
{
    public function rubros()
    {
        return $this->belongsToMany(Rubro::class);
    }

    public function certificadoProveedors()
    {
        return $this->hasMany(CertificadoProveedor::class);
    }
}
