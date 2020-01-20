<?php
declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class N1Acl extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('acl')->insertOrIgnore([
            [
                'key' => 'main',
                'name' => json_encode([
                    'zh_cn' => '公共模块',
                    'en_us' => 'Common Module'
                ], JSON_UNESCAPED_UNICODE),
                'write' => 'uploads',
                'read' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'resource',
                'name' => json_encode([
                    'zh_cn' => '资源控制模块',
                    'en_us' => 'Resource Module'
                ], JSON_UNESCAPED_UNICODE),
                'write' => 'add,edit,delete,sort',
                'read' => 'originLists,lists,get',
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'acl',
                'name' => json_encode([
                    'zh_cn' => '访问控制模块',
                    'en_us' => 'Acl Module'
                ], JSON_UNESCAPED_UNICODE),
                'write' => 'add,edit,delete',
                'read' => 'originLists,lists,get',
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'policy',
                'name' => json_encode([
                    'zh_cn' => '策略模块',
                    'en_us' => 'Policy Module'
                ], JSON_UNESCAPED_UNICODE),
                'write' => 'add,delete',
                'read' => 'originLists',
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'admin',
                'name' => json_encode([
                    'zh_cn' => '管理员模块',
                    'en_us' => 'Admin Module'
                ], JSON_UNESCAPED_UNICODE),
                'write' => 'add,edit,delete',
                'read' => 'originLists,lists,get',
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'role',
                'name' => json_encode([
                    'zh_cn' => '权限组模块',
                    'en_us' => 'Role Module'
                ], JSON_UNESCAPED_UNICODE),
                'write' => 'add,edit,delete',
                'read' => 'originLists,lists,get',
                'create_time' => time(),
                'update_time' => time()
            ]
        ]);
    }
}
