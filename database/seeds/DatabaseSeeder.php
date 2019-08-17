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
            AclTableSeeder::class,
            ResourceTableSeeder::class,
            PolicyTableSeeder::class,
            RoleBasicTableSeeder::class,
            RoleAclTableSeeder::class,
            RoleResourceTableSeeder::class,
            AdminBasicTableSeeder::class,
            AdminRoleTableSeeder::class
        ]);
    }
}
