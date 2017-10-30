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
			'job' => 3,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Jesùs',
			'ap_paterno' => 'Pacheco',
			'ap_materno' => '',
			'password' => \Hash::make( '123456' ),
			'email' => 'jesus@macias-group.com',
			'job' => 2,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Loreana',
			'ap_paterno' => 'Mejia',
			'ap_materno' => 'Escamilla',
			'password' => \Hash::make( '123456' ),
			'email' => 'lorenamejia@macias-group.com',
			'job' => 5,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Hector',
			'ap_paterno' => 'Solis',
			'ap_materno' => 'Osorio',
			'password' => \Hash::make( '123456' ),
			'email' => 'hectorsolis@macias-group.com',
			'job' => 5,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Alejandro',
			'ap_paterno' => 'Gonzalez',
			'ap_materno' => 'Aragon',
			'password' => \Hash::make( '123456' ),
			'email' => 'alejandroaragon@macias-group.com',
			'job' => 2,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Alma',
			'ap_paterno' => 'Cabrera',
			'ap_materno' => '',
			'password' => \Hash::make( '123456' ),
			'email' => 'almacabrera@macias-group.com',
			'job' => 2,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Stephany',
			'ap_paterno' => 'Jimenez',
			'ap_materno' => '',
			'password' => \Hash::make( '123456' ),
			'email' => 'stephanyjimenez@macias-group.com',
			'job' => 2,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Antonio',
			'ap_paterno' => 'Colin',
			'ap_materno' => '',
			'password' => \Hash::make( '123456' ),
			'email' => 'santoniocolin@macias-group.com',
			'job' => 2,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Itzel Zayra',
			'ap_paterno' => 'Torres',
			'ap_materno' => 'Martinez',
			'password' => \Hash::make( '123456' ),
			'email' => 'itzeltorres@macias-group.com',
			'job' => 12,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Jessica',
			'ap_paterno' => 'Rosales',
			'ap_materno' => 'Razgado',
			'password' => \Hash::make( '123456' ),
			'email' => 'recepcionidf@macias-group.com',
			'job' => 12,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Humberto',
			'ap_paterno' => 'Alonso',
			'ap_materno' => 'Pineda',
			'password' => \Hash::make( '123456' ),
			'email' => 'humbertopineda@macias-group.com',
			'job' => 12,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Yessica Elizabeth',
			'ap_paterno' => 'Jimenez',
			'ap_materno' => 'Ramirez',
			'password' => \Hash::make( '123456' ),
			'email' => 'yessicajimenez@macias-group.com',
			'job' => 12,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('users')->insert([
			'name' => 'Rocio',
			'ap_paterno' => 'Samano',
			'ap_materno' => '',
			'password' => \Hash::make( '123456' ),
			'email' => 'rociosamano@macias-group.com',
			'job' => 11,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
    }
}
