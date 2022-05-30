<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Evento as EventoResource;
use App\Http\Resources\Resena as ResenaResource;
use App\Http\Resources\Denuncia as DenunciaResource;

class Cliente extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'bio' => $this->bio,
            'email' => $this->email,
            'eventos' => EventoResource::collection($this->whenLoaded('eventos')),
            'resenas' => ResenaResource::collection($this->whenLoaded('resenas')),
            'denuncias' => DenunciaResource::collection($this->whenLoaded('denuncias'))
        ];
    }
}
