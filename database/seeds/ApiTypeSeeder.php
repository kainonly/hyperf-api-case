<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApiTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('api_type')->insert([
            [
                'id' => 1,
                'name' => json_encode([
                    'zh_cn' => '基础模块',
                    'en_us' => 'Base Module'
                ], JSON_UNESCAPED_UNICODE),
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 2,
                'name' => json_encode([
                    'zh_cn' => '路由模块',
                    'en_us' => 'Router Module'
                ], JSON_UNESCAPED_UNICODE),
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 3,
                'name' => json_encode([
                    'zh_cn' => '接口模块',
                    'en_us' => 'Api Module'
                ], JSON_UNESCAPED_UNICODE),
                'create_time' => time(),
                'update_time' => time()
            ]
            , [
                'id' => 4,
                'name' => json_encode([
                    'zh_cn' => '接口类型模块',
                    'en_us' => 'Api Type Module'
                ], JSON_UNESCAPED_UNICODE),
                'create_time' => time(),
                'update_time' => time()
            ]
            , [
                'id' => 5,
                'name' => json_encode([
                    'zh_cn' => '管理员模块',
                    'en_us' => 'Admin Module'
                ], JSON_UNESCAPED_UNICODE),
                'create_time' => time(),
                'update_time' => time()
            ]
            , [
                'id' => 6,
                'name' => json_encode([
                    'zh_cn' => '权限组模块',
                    'en_us' => 'Router Module'
                ], JSON_UNESCAPED_UNICODE),
                'create_time' => time(),
                'update_time' => time()
            ]
        ]);
    }
}
