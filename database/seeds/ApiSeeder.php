<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('api')->insert([
            [
                'id' => 1,
                'type' => 1,
                'name' => json_encode([
                    'zh_cn' => '上传文件',
                    'en_us' => 'Uploads'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'main/uploads',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 2,
                'type' => 2,
                'name' => json_encode([
                    'zh_cn' => '获取列表数据',
                    'en_us' => 'Origin Lists'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'router/originLists',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 3,
                'type' => 2,
                'name' => json_encode([
                    'zh_cn' => '获取单条数据',
                    'en_us' => 'Get'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'router/get',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 4,
                'type' => 2,
                'name' => json_encode([
                    'zh_cn' => '新增接口',
                    'en_us' => 'Add'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'router/add',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 5,
                'type' => 2,
                'name' => json_encode([
                    'zh_cn' => '修改接口',
                    'en_us' => 'Edit'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'router/edit',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 6,
                'type' => 2,
                'name' => json_encode([
                    'zh_cn' => '删除接口',
                    'en_us' => 'Delete'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'router/delete',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 7,
                'type' => 2,
                'name' => json_encode([
                    'zh_cn' => '排序接口',
                    'en_us' => 'Sort'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'router/sort',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 8,
                'type' => 3,
                'name' => json_encode([
                    'zh_cn' => '获取列表数据',
                    'en_us' => 'Origin Lists'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'api/originLists',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 9,
                'type' => 3,
                'name' => json_encode([
                    'zh_cn' => '获取分页数据',
                    'en_us' => 'Lists'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'api/lists',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 10,
                'type' => 3,
                'name' => json_encode([
                    'zh_cn' => '获取单条数据',
                    'en_us' => 'Get'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'api/get',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 11,
                'type' => 3,
                'name' => json_encode([
                    'zh_cn' => '新增接口',
                    'en_us' => 'Add'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'api/add',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 12,
                'type' => 3,
                'name' => json_encode([
                    'zh_cn' => '修改接口',
                    'en_us' => 'Edit'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'api/edit',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 13,
                'type' => 3,
                'name' => json_encode([
                    'zh_cn' => '删除接口',
                    'en_us' => 'Delete'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'api/delete',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 14,
                'type' => 4,
                'name' => json_encode([
                    'zh_cn' => '获取列表数据',
                    'en_us' => 'Origin Lists'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'api_type/originLists',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 15,
                'type' => 4,
                'name' => json_encode([
                    'zh_cn' => '获取单条数据',
                    'en_us' => 'Get'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'api_type/get',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 16,
                'type' => 4,
                'name' => json_encode([
                    'zh_cn' => '新增接口',
                    'en_us' => 'Add'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'api_type/add',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 17,
                'type' => 4,
                'name' => json_encode([
                    'zh_cn' => '修改接口',
                    'en_us' => 'Edit'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'api_type/edit',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 18,
                'type' => 4,
                'name' => json_encode([
                    'zh_cn' => '删除接口',
                    'en_us' => 'Delete'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'api_type/delete',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 19,
                'type' => 5,
                'name' => json_encode([
                    'zh_cn' => '获取列表数据',
                    'en_us' => 'Origin Lists'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'admin/originLists',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 20,
                'type' => 5,
                'name' => json_encode([
                    'zh_cn' => '获取分页数据',
                    'en_us' => 'Lists'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'admin/lists',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 21,
                'type' => 5,
                'name' => json_encode([
                    'zh_cn' => '获取单条数据',
                    'en_us' => 'Get'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'admin/get',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 22,
                'type' => 5,
                'name' => json_encode([
                    'zh_cn' => '新增接口',
                    'en_us' => 'Add'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'admin/add',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 23,
                'type' => 5,
                'name' => json_encode([
                    'zh_cn' => '修改接口',
                    'en_us' => 'Edit'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'admin/edit',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 24,
                'type' => 5,
                'name' => json_encode([
                    'zh_cn' => '删除接口',
                    'en_us' => 'Delete'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'admin/delete',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 25,
                'type' => 6,
                'name' => json_encode([
                    'zh_cn' => '获取列表数据',
                    'en_us' => 'Origin Lists'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'role/originLists',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 26,
                'type' => 6,
                'name' => json_encode([
                    'zh_cn' => '获取分页数据',
                    'en_us' => 'Lists'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'role/lists',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 27,
                'type' => 6,
                'name' => json_encode([
                    'zh_cn' => '获取单条数据',
                    'en_us' => 'Get'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'role/get',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 28,
                'type' => 6,
                'name' => json_encode([
                    'zh_cn' => '新增接口',
                    'en_us' => 'Add'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'role/add',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 29,
                'type' => 6,
                'name' => json_encode([
                    'zh_cn' => '修改接口',
                    'en_us' => 'Edit'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'role/edit',
                'create_time' => time(),
                'update_time' => time()
            ], [
                'id' => 30,
                'type' => 6,
                'name' => json_encode([
                    'zh_cn' => '删除接口',
                    'en_us' => 'Delete'
                ], JSON_UNESCAPED_UNICODE),
                'api' => 'role/delete',
                'create_time' => time(),
                'update_time' => time()
            ]
        ]);
    }
}
