<?php

use Illuminate\Database\Seeder;

class ViasTableSeeder extends Seeder
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
		DB::table('vias')->insert([
			'via' => 'Aspera',
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('vias')->insert([
			'Fox Fast' => 'Aspera',
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('vias')->insert([
			'WB DETE' => 'Aspera',
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('vias')->insert([
			'WB MPI ASPERA' => 'Aspera',
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('vias')->insert([
			'WB MPI ASPERA' => 'Aspera',
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('vias')->insert([
			'DELUXE MEDIA' => 'Aspera',
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
    }
}
