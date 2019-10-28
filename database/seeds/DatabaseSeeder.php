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
        $this->call([
            AclSeeder::class,
            ResourceSeeder::class,
            PolicySeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
