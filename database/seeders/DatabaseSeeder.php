<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ModulosTableSeeder::class);
        // $this->call(SubmodulosTableSeeder::class);
        // $this->call(AccesosTableSeeder::class);
        // $this->call(RolesTableSeeder::class);
        // $this->call(PermisosTableSeeder::class);
        // $this->call(UsuariosTableSeeder::class);
        // $this->call(LogsTableSeeder::class);
        $this->call([
            ModulosTableSeeder::class,
            SubmodulosTableSeeder::class,
            AccesosTableSeeder::class,
            RolesTableSeeder::class,
            PermisosTableSeeder::class,
            UsuariosTableSeeder::class,
            // LogsTableSeeder::class
        ]);
    }
}
