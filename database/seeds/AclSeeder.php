<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AclSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('acl')->insert([
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
                'write' => 'add,edit,delete',
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

        (new \App\Http\System\Redis\AclRedis())->refresh();
    }
}
