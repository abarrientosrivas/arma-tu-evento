<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\Cliente as ClienteResource;

class Denuncia extends JsonResource
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
          'titulo' => $this->titulo,
          'descripcion' => $this->descripcion,
          'post' => PostResource::collection($this->whenLoaded('post')),
          'cliente' => ClienteResource::collection($this->whenLoaded('cliente'))
        ];
    }
}
