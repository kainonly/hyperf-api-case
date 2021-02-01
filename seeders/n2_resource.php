<?php
declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class N2Resource extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Db::table('resource')->insertOrIgnore([
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
                'key' => 'control',
                'parent' => 'system',
                'name' => json_encode([
                    'zh_cn' => '控制授权',
                    'en_us' => 'Control'
                ]),
                'nav' => 1,
                'router' => 0,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'acl-index',
                'parent' => 'control',
                'name' => json_encode([
                    'zh_cn' => '访问项',
                    'en_us' => 'Acl'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'router' => 1,
                'policy' => 1,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'acl-add',
                'parent' => 'acl-index',
                'name' => json_encode([
                    'zh_cn' => '访问项新增',
                    'en_us' => 'Acl Add'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'acl-edit',
                'parent' => 'acl-index',
                'name' => json_encode([
                    'zh_cn' => '访问项修改',
                    'en_us' => 'Acl Edit'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'resource-index',
                'parent' => 'control',
                'name' => json_encode([
                    'zh_cn' => '资源项',
                    'en_us' => 'Resource'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'router' => 1,
                'policy' => 1,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'resource-add',
                'parent' => 'resource-index',
                'name' => json_encode([
                    'zh_cn' => '资源项新增',
                    'en_us' => 'Resource Add'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'resource-edit',
                'parent' => 'resource-index',
                'name' => json_encode([
                    'zh_cn' => '资源项修改',
                    'en_us' => 'Resource Edit'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'permission-index',
                'parent' => 'system',
                'name' => json_encode([
                    'zh_cn' => '特殊授权',
                    'en_us' => 'Permission'
                ]),
                'nav' => 1,
                'router' => 1,
                'policy' => 1,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'permission-add',
                'parent' => 'permission-index',
                'name' => json_encode([
                    'zh_cn' => '特殊授权新增',
                    'en_us' => 'Permission Add'
                ]),
                'nav' => 0,
                'router' => 1,
                'policy' => 0,
                'icon' => null,
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'permission-edit',
                'parent' => 'permission-index',
                'name' => json_encode([
                    'zh_cn' => '特殊授权修改',
                    'en_us' => 'Permission Edit'
                ]),
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
                'parent' => 'origin',
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
            ],
            [
                'key' => 'media',
                'parent' => 'origin',
                'name' => json_encode([
                    'zh_cn' => '多媒体管理',
                    'en_us' => 'Media'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'router' => 0,
                'policy' => 0,
                'icon' => 'play-circle',
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'picture',
                'parent' => 'media',
                'name' => json_encode([
                    'zh_cn' => '图片素材',
                    'en_us' => 'Picture'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'router' => 1,
                'policy' => 1,
                'icon' => '',
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'video',
                'parent' => 'media',
                'name' => json_encode([
                    'zh_cn' => '视频素材',
                    'en_us' => 'Video'
                ], JSON_UNESCAPED_UNICODE),
                'nav' => 1,
                'router' => 1,
                'policy' => 1,
                'icon' => '',
                'create_time' => time(),
                'update_time' => time()
            ],
        ]);
    }
}
