<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Certificado;

class Rubro extends Model
{
    public $timestamps = false;

    public function certificados()
    {
      return $this->belongsToMany(Certificado::class);
    }

}
