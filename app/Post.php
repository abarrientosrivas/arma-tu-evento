<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Proveedor;
use App\Resena;
use App\Rubro;
use App\Evento;
use App\Denuncia;
use App\Solicitud;
use App\PostImage;

class Post extends Model
{
    public function rubro()
    {
      return $this->belongsTo(Rubro::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function resenas()
    {
      return $this->hasMany(Resena::class);
    }

    public function denuncias()
    {
      return $this->hasMany(Denuncia::class);
    }

    public function eventos()
    {
      return $this->belongsToMany(Evento::class);
    }

    public function PostImages()
    {
      return $this->hasMany(PostImage::class);
    }

    public function solicituds()
    {
      return $this->hasMany(Solicitud::class);
    }
}
