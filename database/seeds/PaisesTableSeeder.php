<?php

use Illuminate\Database\Seeder;

class PaisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		$carbon = new \Carbon\Carbon();
		\DB::table('paises')->insert([
			'pais' => 'México',
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);

        \DB::table('paises')->insert([
            'pais' => 'Brasil',
            'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
            'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
        ]);
    }
}
