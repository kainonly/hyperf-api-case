<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('policy')->insert([
            [
                'resource_key' => 'resource-index',
                'acl_key' => 'resource',
                'policy' => 1
            ],
            [
                'resource_key' => 'acl-index',
                'acl_key' => 'acl',
                'policy' => 1
            ],
            [
                'resource_key' => 'role-index',
                'acl_key' => 'role',
                'policy' => 1
            ],
            [
                'resource_key' => 'admin-index',
                'acl_key' => 'admin',
                'policy' => 1
            ],
            [
                'resource_key' => 'admin-index',
                'acl_key' => 'role',
                'policy' => 0
            ],
        ]);
    }
}
