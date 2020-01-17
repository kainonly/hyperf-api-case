<?php
declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class N3Policy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('policy')->insertOrIgnore([
            [
                'resource_key' => 'acl-index',
                'acl_key' => 'acl',
                'policy' => 1
            ],
            [
                'resource_key' => 'resource-index',
                'acl_key' => 'resource',
                'policy' => 1
            ],
            [
                'resource_key' => 'resource-index',
                'acl_key' => 'policy',
                'policy' => 1
            ],
            [
                'resource_key' => 'resource-index',
                'acl_key' => 'acl',
                'policy' => 0
            ],
            [
                'resource_key' => 'role-index',
                'acl_key' => 'role',
                'policy' => 1
            ],
            [
                'resource_key' => 'role-index',
                'acl_key' => 'resource',
                'policy' => 0
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
            ]
        ]);
    }
}
