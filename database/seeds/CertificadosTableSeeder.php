<?php

use Illuminate\Database\Seeder;
use App\Certificado;

class CertificadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $certificados = [
            ['titulo' => 'Manipulación de alimentos', 'rubro_id' => 3, 'obligatorio' => true],
            ['titulo' => 'Habilitación municipal', 'rubro_id' => 11, 'obligatorio' => true],
            ['titulo' => 'Habilitación prestadora de servicios de seguridad', 'rubro_id' => 9, 'obligatorio' => true],
            ['titulo' => 'Certifficado AADI', 'rubro_id' => 2, 'obligatorio' => true],
            ['titulo' => 'Certificado CAPIF', 'rubro_id' => 8, 'obligatorio' => true],
            ['titulo' => 'Registro de proveedores', 'rubro_id' => 1, 'obligatorio' => true]
        ];

        Certificado::insert($certificados);
    }
}
