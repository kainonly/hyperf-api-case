<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            DB::table('role_basic')->insert([
                'name' => json_encode([
                    'zh_cn' => '超级管理员',
                    'en_us' => 'super'
                ], JSON_UNESCAPED_UNICODE),
                'key' => '*',
                'create_time' => time(),
                'update_time' => time()
            ]);

            $acl = DB::table('acl')
                ->get(['key'])
                ->map(function ($v) {
                    return [
                        'role_key' => '*',
                        'acl_key' => $v->key,
                        'policy' => 'rw'
                    ];
                });

            DB::table('role_acl')
                ->insert($acl->toArray());

            $resource = DB::table('resource')
                ->get(['key'])
                ->map(function ($v) {
                    return [
                        'role_key' => '*',
                        'resource_key' => $v->key
                    ];
                });

            DB::table('role_resource')
                ->insert($resource->toArray());
        });

        (new \App\Http\System\Redis\Role())->refresh();
    }
}
