<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('router')->insert([
            [
                'id' => 1,
                'parent' => 0,
                'name' => json_encode([
                    'zh_cn' => '系统设置',
                    'en_us' => 'System'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'icon' => 'setting',
                'routerlink' => '',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 2,
                'parent' => 1,
                'name' => json_encode([
                    'zh_cn' => '路由管理',
                    'en_us' => 'Router'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'icon' => '',
                'routerlink' => 'router-index',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 3,
                'parent' => 2,
                'name' => json_encode([
                    'zh_cn' => '路由新增',
                    'en_us' => 'Router Add'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'icon' => '',
                'routerlink' => 'router-add',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 4,
                'parent' => 2,
                'name' => json_encode([
                    'zh_cn' => '路由修改',
                    'en_us' => 'Router Edit'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'icon' => '',
                'routerlink' => 'router-edit',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 5,
                'parent' => 1,
                'name' => json_encode([
                    'zh_cn' => '权限组',
                    'en_us' => 'Role'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'icon' => '',
                'routerlink' => 'role-index',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 6,
                'parent' => 5,
                'name' => json_encode([
                    'zh_cn' => '权限组新增',
                    'en_us' => 'Role Add'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'icon' => '',
                'routerlink' => 'role-add',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 7,
                'parent' => 5,
                'name' => json_encode([
                    'zh_cn' => '权限组修改',
                    'en_us' => 'Role Edit'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'icon' => '',
                'routerlink' => 'role-edit',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 8,
                'parent' => 1,
                'name' => json_encode([
                    'zh_cn' => '接口管理',
                    'en_us' => 'Api'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'icon' => '',
                'routerlink' => 'api-index',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 9,
                'parent' => 8,
                'name' => json_encode([
                    'zh_cn' => '接口新增',
                    'en_us' => 'Api Add'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'icon' => '',
                'routerlink' => 'api-add',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 10,
                'parent' => 8,
                'name' => json_encode([
                    'zh_cn' => '接口修改',
                    'en_us' => 'Api Edit'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'icon' => '',
                'routerlink' => 'api-edit',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 11,
                'parent' => 1,
                'name' => json_encode([
                    'zh_cn' => '管理员管理',
                    'en_us' => 'Admin'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'icon' => '',
                'routerlink' => 'admin-index',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 12,
                'parent' => 11,
                'name' => json_encode([
                    'zh_cn' => '管理员新增',
                    'en_us' => 'Admin Add'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'icon' => '',
                'routerlink' => 'admin-add',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 13,
                'parent' => 11,
                'name' => json_encode([
                    'zh_cn' => '管理员修改',
                    'en_us' => 'Admin Edit'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'icon' => '',
                'routerlink' => 'admin-edit',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 14,
                'parent' => 0,
                'name' => json_encode([
                    'zh_cn' => '个人中心',
                    'en_us' => 'Center'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'icon' => '',
                'routerlink' => '',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 15,
                'parent' => 14,
                'name' => json_encode([
                    'zh_cn' => '信息修改',
                    'en_us' => 'Profile'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'icon' => '',
                'routerlink' => 'profile',
                'sort' => 0,
                'create_time' => time(),
                'update_time' => time()
            ],
        ]);
    }
}
