<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Post;
use App\Pago;
use App\Rubro;
use App\TipoPago;
use App\CertificadoProveedor;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    // The authentication guard for proveedor
    protected $guard = 'proveedor-api';

    public function rubro()
    {
        return $this->belongsTo(Rubro::class);
    }
    
    public function tipopago()
    {
        return $this->belongsTo(TipoPago::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function certificados()
    {
        return $this->hasMany(CertificadoProveedor::class);
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

    /**
      * The attributes that should be hidden for arrays.
      *
      * @var array
      */
      protected $hidden = [
        'password', 'remember_token',
    ];

}
