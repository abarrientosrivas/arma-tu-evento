<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Proveedor as ProveedorResource;
use App\Http\Resources\Rubro as RubroResource;

class Certificado extends JsonResource
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
            // 'proveedor_id' => $this->proveedor_id,
            // 'proveedor' => ProveedorResource::collection($this->whenLoaded('proveedor')),
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            // 'fecha' => $this->fecha,
            'obligatorio' => $this->obligatorio,
            'rubros' => RubroResource::collection($this->whenLoaded('rubros'))
        ];
    }
}
