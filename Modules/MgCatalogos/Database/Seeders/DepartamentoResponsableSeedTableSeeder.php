<?php

namespace Modules\MgCatalogos\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DepartamentoResponsableSeedTableSeeder extends Seeder
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
        DB::table('rechazo_departamento_responsable')->insert([
            'nombre' => "Traducciones de portugués",
            'descripcion' => "Traducciones de portugués"
        ]);
        DB::table('rechazo_departamento_responsable')->insert([
            'nombre' => "Traducciones de inglés",
            'descripcion' => "Traducciones de inglés"
        ]);
        DB::table('rechazo_departamento_responsable')->insert([
            'nombre' => "Miami",
            'descripcion' => "Miami"
        ]);
        DB::table('rechazo_departamento_responsable')->insert([
            'nombre' => "Coordinación de proyectos",
            'descripcion' => "Coordinación de proyectos"
        ]);
        DB::table('rechazo_departamento_responsable')->insert([
            'nombre' => "Producción IDF 1",
            'descripcion' => "Producción IDF 1"
        ]);
        DB::table('rechazo_departamento_responsable')->insert([
            'nombre' => "Producción IDF 2",
            'descripcion' => "Producción IDF 2"
        ]);
        DB::table('rechazo_departamento_responsable')->insert([
            'nombre' => "Producción sebastians",
            'descripcion' => "Producción sebastians"
        ]);
        DB::table('rechazo_departamento_responsable')->insert([
            'nombre' => "Producción globo",
            'descripcion' => "Producción globo"
        ]);
        DB::table('rechazo_departamento_responsable')->insert([
            'nombre' => "Pistas",
            'descripcion' => "Pistas"
        ]);
        DB::table('rechazo_departamento_responsable')->insert([
            'nombre' => "Ingeniería",
            'descripcion' => "Ingeniería"
        ]);
        DB::table('rechazo_departamento_responsable')->insert([
            'nombre' => "Tráfico",
            'descripcion' => "Tráfico"
        ]);
    }
}
