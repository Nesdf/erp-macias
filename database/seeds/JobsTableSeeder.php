<?php

use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $jobs = [
            'Director', 
            'Productor', 
            'Administrador', 
            'CEO', 
            'Gerente Corporativo de proyectos', 
            'Operador de audio', 
            'Regrabador', 
            'Sincronizador',
            'Editor de pistas internacionales',
            'Director de doblaje',
            'Coordinador de Llamados',
            'Auxiliar de Llamados'
        ];
		$carbon = new \Carbon\Carbon();
        $num = 0;
        foreach ($jobs as $key => $value) {
            DB::table('jobs')->insert([
                'job' => $jobs[$num],
                'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
                'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
            ]);
            $num++;
        }
    }
}
