<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resource')->insert([
            [
                'key' => 'system',
                'parent' => 'origin',
                'name' => json_encode([
                    'zh_cn' => '系统设置',
                    'en_us' => 'System'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'router' => 0,
                'policy' => 0,
                'icon' => 'setting',
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'router-index',
                'parent' => 'system',
                'name' => json_encode([
                    'zh_cn' => '路由管理',
                    'en_us' => 'Router'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'router' => 1,
                'policy' => 1,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'router-add',
                'parent' => 'router-index',
                'name' => json_encode([
                    'zh_cn' => '路由新增',
                    'en_us' => 'Router Add'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'router-edit',
                'parent' => 'router-index',
                'name' => json_encode([
                    'zh_cn' => '路由修改',
                    'en_us' => 'Router Edit'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'api-index',
                'parent' => 'system',
                'name' => json_encode([
                    'zh_cn' => '接口管理',
                    'en_us' => 'Api'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'router' => 1,
                'policy' => 1,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'api-add',
                'parent' => 'api-index',
                'name' => json_encode([
                    'zh_cn' => '接口新增',
                    'en_us' => 'Api Add'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'api-edit',
                'parent' => 'api-index',
                'name' => json_encode([
                    'zh_cn' => '接口修改',
                    'en_us' => 'Api Edit'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'role-index',
                'parent' => 'system',
                'name' => json_encode([
                    'zh_cn' => '权限组',
                    'en_us' => 'Role'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'router' => 1,
                'policy' => 1,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'role-add',
                'parent' => 'role-index',
                'name' => json_encode([
                    'zh_cn' => '权限组新增',
                    'en_us' => 'Role Add'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'role-edit',
                'parent' => 'role-index',
                'name' => json_encode([
                    'zh_cn' => '权限组修改',
                    'en_us' => 'Role Edit'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'admin-index',
                'parent' => 'system',
                'name' => json_encode([
                    'zh_cn' => '管理员',
                    'en_us' => 'Admin'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'router' => 1,
                'policy' => 1,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'admin-add',
                'parent' => 'admin-index',
                'name' => json_encode([
                    'zh_cn' => '管理员新增',
                    'en_us' => 'Admin Add'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'admin-edit',
                'parent' => 'admin-index',
                'name' => json_encode([
                    'zh_cn' => '管理员修改',
                    'en_us' => 'Admin Edit'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'center',
                'parent' => 'system',
                'name' => json_encode([
                    'zh_cn' => '个人中心',
                    'en_us' => 'Center'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 0,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'profile',
                'parent' => 'center',
                'name' => json_encode([
                    'zh_cn' => '信息修改',
                    'en_us' => 'Profile'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ]
        ]);
    }
}
