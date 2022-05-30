<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Pago extends JsonResource
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
            'proveedor' => ProveedorResource::collection($this->whenLoaded('proveedor')),
            'monto' => $this->monto,
            'fecha_pago' => $this->fecha_pago,
            'fecha_fin' => $this->fecha_fin
        ];
    }
}
