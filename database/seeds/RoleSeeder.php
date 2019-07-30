<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use lumen\bit\common\Ext;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $router = DB::table('router')
            ->get(['id'])
            ->pluck('id')
            ->toArray();

        $api = DB::table('api')
            ->get(['id'])
            ->pluck('id')
            ->toArray();

        DB::table('role')->insert([
            'id' => 1,
            'name' => json_encode([
                'zh_cn' => '系统管理员',
                'en_us' => 'Super'
            ], JSON_UNESCAPED_UNICODE),
            'router' => Ext::pack($router),
            'api' => Ext::pack($api),
            'create_time' => time(),
            'update_time' => time()
        ]);
    }
}
