<?php

use Illuminate\Database\Seeder;

class RouteAccessTableSedder extends Seeder
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
		DB::table('routes_access')->insert([
			'alias_name' => 'mgpersonal',
			'user_id' => 1,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('routes_access')->insert([
			'alias_name' => 'add_personal',
			'user_id' => 1,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('routes_access')->insert([
			'alias_name' => 'add_permisos',
			'user_id' => 1,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('routes_access')->insert([
			'alias_name' => 'permisos_acceso',
			'user_id' => 1,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('routes_access')->insert([
			'alias_name' => 'edit_personal',
			'user_id' => 1,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
		DB::table('routes_access')->insert([
			'alias_name' => 'update_personal',
			'user_id' => 1,
			'created_at' => $carbon->now()->format('Y-m-d H:i:s'),
			'updated_at' => $carbon->now()->format('Y-m-d H:i:s')
		]);
    }
}
