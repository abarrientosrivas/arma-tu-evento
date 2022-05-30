<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Proveedor as ProveedorResource;
use App\Http\Resources\Rubro as RubroResource;
use App\Http\Resources\Resena as ResenaResource;
use App\Http\Resources\PostImage as PostImageResource;
use App\Http\Resources\Denuncia as DenunciaResource;

class Post extends JsonResource
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
            'proveedor' => ProveedorResource::collection($this->whenLoaded('proveedor')),
            'rubro' => RubroResource::collection($this->rubro),
            'titulo' => $this->titulo,
            'cuerpo' => $this->cuerpo,
            'maxPersonas' => $this->maxPersonas,
            'featuredImage' => $this->featuredImage,
            'resenas' => ResenaResource::collection($this->whenLoaded('resenas')),
            'denuncias' => DenunciaResource::collection($this->whenLoaded('denuncias')),
            'images' => PostImageResource::collection($this->whenLoaded('postImages'))
        ];
    }
}
