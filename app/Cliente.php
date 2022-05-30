<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Evento;
use App\Resena;

class Cliente extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    // The authentication guard for proveedor
    protected $guard = 'cliente-api';

    // protected $table = 'clientes';

    // protected $fillable = ['nombre', 'apellido', 'email', 'password',];

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }

    public function denuncias()
    {
      return $this->hasMany(Denuncia::class);
    }

    public function conversations()
    {
      return $this->hasMany(App\Conversation::class);
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $hidden = ['password', 'rememberToken',];
}
