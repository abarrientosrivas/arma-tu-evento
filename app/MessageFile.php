<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageFile extends Model
{
    //
    public function message()
    {
        return $this->belongsTo(App\Message::class);
    }
}
