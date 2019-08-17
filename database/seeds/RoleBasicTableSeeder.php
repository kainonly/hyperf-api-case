<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleBasicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_basic')->insert([
            'name' => json_encode([
                'zh_cn' => '超级管理员',
                'en_us' => 'super'
            ], JSON_UNESCAPED_UNICODE),
            'key' => '*',
            'create_time' => time(),
            'update_time' => time()
        ]);
    }
}
