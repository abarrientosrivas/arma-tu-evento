<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conversation;
use App\MessageFile;

class Message extends Model
{
    //
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function messageFile()
    {
        return $this->hasOne(MessageFile::class);
    }
}
