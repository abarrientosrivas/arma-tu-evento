<?php

namespace App\Events;

use App\Cliente;
use App\Proveedor;
use App\Notificacion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificacionSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Message details
     *
     * @var Notificacion
     */
    public $notificacion;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Notificacion $notificacion)
    {
        $this->notificacion = $notificacion;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('notificacion');
        return ['notificacion'];
    }
}
