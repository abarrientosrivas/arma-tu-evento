<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Cliente as ClienteResource;
use App\Http\Resources\Post as PostResource;

class Evento extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'cliente' => ClienteResource::collection($this->whenLoaded('cliente')),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'cantPersonas' => $this->cantPersonas,
            'fecha' => $this->fecha,
            'estado' => $this->estado
        ];
    }
}
