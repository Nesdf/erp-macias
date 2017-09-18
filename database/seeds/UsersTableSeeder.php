<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
		DB::table('users')->insert([
			'name' => 'Nestor',
			'ap_paterno' => 'Perez',
			'ap_materno' => 'Sanchez',
			'password' => \Hash::make( '123456' ),
			'email' => 'nes64df@gmail.com',
			'job' => 'Director',
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
    }
}
