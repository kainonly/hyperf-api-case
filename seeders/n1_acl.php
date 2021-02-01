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
                'key' => 'permission',
                'name' => json_encode([
                    'zh_cn' => '特殊授权模块',
                    'en_us' => 'Policy Module'
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
            ],
            [
                'key' => 'picture_type',
                'name' => json_encode([
                    'zh_cn' => '图片素材分类模块',
                    'en_us' => 'Picture Type Module'
                ], JSON_UNESCAPED_UNICODE),
                'write' => 'add,edit,delete,sort',
                'read' => 'originLists',
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'picture',
                'name' => json_encode([
                    'zh_cn' => '图片素材模块',
                    'en_us' => 'Picture Module'
                ], JSON_UNESCAPED_UNICODE),
                'write' => 'bulkAdd,edit,bulkEdit,delete',
                'read' => 'lists,count',
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'video_type',
                'name' => json_encode([
                    'zh_cn' => '视频素材分类模块',
                    'en_us' => 'Video Type Module'
                ], JSON_UNESCAPED_UNICODE),
                'write' => 'add,edit,delete,sort',
                'read' => 'originLists',
                'create_time' => time(),
                'update_time' => time()
            ],
            [
                'key' => 'video',
                'name' => json_encode([
                    'zh_cn' => '视频素材模块',
                    'en_us' => 'Video
                     Module'
                ], JSON_UNESCAPED_UNICODE),
                'write' => 'bulkAdd,edit,bulkEdit,delete',
                'read' => 'lists,count',
                'create_time' => time(),
                'update_time' => time()
            ]
        ]);
    }
}
