<?php

namespace App;

use App\Evento;
use App\Post;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use SoftDeletes;
    //
    public function evento()
    {
      return $this->belongsTo(Evento::class);
    }

    //
    public function post()
    {
      return $this->belongsTo(Post::class);
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
