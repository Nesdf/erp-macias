<?php

use Illuminate\Database\Seeder;

class SalasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $salas = [
            'IDF 1', 
            'IDF 2', 
            'IDF 3', 
            'IDF 4', 
            'IDF 5', 
            'IDF 6', 
            'IDF 7', 
            'IDF 8',
            'IDF 9',
            'Sala De Cine',
            'Monte Carlo',
            'Saint Tropez', 
            'Capri', 
            'Tulum', 
            'Fortaleza', 
            'Recife', 
            'Porto Alegre', 
            'Belo Horizonte',
            'Cancun',
            'Los Cabos'
        ];
		$carbon = new \Carbon\Carbon();
        $num = 0;
        foreach ($salas as $key => $value) {
            DB::table('salas')->insert([
                'sala' => $salas[$num],
                'estudio_id' =>1,
                'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
                'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
            ]);
            $num++;
        }
    }
}
