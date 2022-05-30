<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Proveedor;

class Pago extends Model
{
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
}
