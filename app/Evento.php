<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Post;
use App\Cliente;
use App\Solicitud;

class Evento extends Model
{
    use SoftDeletes;
    //
    public function cliente()
    {
      return $this->belongsTo(Cliente::class);
    }

    public function posts()
    {
      return $this->belongsToMany(Post::class);
    }

    public function solicituds()
    {
      return $this->hasMany(Solicitud::class);
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
