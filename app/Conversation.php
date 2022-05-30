<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cliente;
use App\Proveedor;
use App\Message;

class Conversation extends Model
{
    //
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
