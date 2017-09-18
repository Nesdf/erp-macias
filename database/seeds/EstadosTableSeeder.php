<?php

use Illuminate\Database\Seeder;

class EstadosTableSeeder extends Seeder
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
		\DB::table('estados')->insert([
			'estado' => 'CDMX',
			'paisesId' => '1',
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);

		\DB::table('estados')->insert([
			'estado' => 'Sao Paolo',
			'paisesId' => '2',
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);

		\DB::table('estados')->insert([
			'estado' => 'Rìo de Janeiro',
			'paisesId' => '2',
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
    }
}
