<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\Rubro as RubroResource;
use App\Http\Resources\TipoPago as TipoPagoResource;
use App\Http\Resources\CertificadoProveedor as CertificadoProveedorResource;

class Proveedor extends JsonResource
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
            'rubro' => RubroResource::collection($this->rubro),
            'tipo_susc' => TipoPagoResource::collection($this->tipopago),
            'nombre' => $this->nombre,
            'cuit' => $this->cuit,
            'email' => $this->email,
            'descripcion' => $this->descripcion,
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'certificados' => CertificadoProveedorResource::collection($this->whenLoaded('certificados'))
        ];
    }
}
