<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
		$this->call(JobsTableSeeder::class);
		$this->call(TcrsTableSeeder::class);
        $this->call(PaisesTableSeeder::class);
        $this->call(EstadosTableSeeder::class);
        $this->call(RouteAccessTableSedder::class);
        $this->call(EstudiosTableSeeder::class);
        $this->call(ViasTableSeeder::class);
        $this->call(SalasTableSeeder::class);
    }
}
