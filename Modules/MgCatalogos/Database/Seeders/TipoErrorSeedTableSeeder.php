<?php

namespace Modules\MgCatalogos\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TipoErrorSeedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Falta diálogo",
            'descripcion' => "Falta diálogo"
        ]);
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Diálogo mal atribuido",
            'descripcion' => "Diálogo mal atribuido"
        ]);
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Traducción errónea",
            'descripcion' => "Traducción errónea"
        ]);
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Mal leído",
            'descripcion' => "Mal leído"
        ]);
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Pronunciación erronea",
            'descripcion' => "Pronunciación erronea"
        ]);
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Término diferente al glosario",
            'descripcion' => "Término diferente al glosario"
        ]);
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Rudio digital",
            'descripcion' => "Rudio digital "
        ]);
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Drop en audio",
            'descripcion' => "Drop en audio"
        ]);
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Sincronia mala",
            'descripcion' => "Sincronia mala"
        ]);
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Barrido",
            'descripcion' => "Barrido"
        ]);
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Diálogo no se entiende por mezcla",
            'descripcion' => "Diálogo no se entiende por mezcla"
        ]);
        DB::table('rechazo_tipo_error')->insert([
            'nombre' => "Niveles de mezcla",
            'descripcion' => "Niveles de mezcla"
        ]);
    }
}
