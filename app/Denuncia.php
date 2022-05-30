<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\Cliente;

class Denuncia extends Model
{
  public function post()
  {
    return $this->belongsTo(Post::class);
  }
  public function cliente()
  {
    return $this->belongsTo(Cliente::class);
  }
}
