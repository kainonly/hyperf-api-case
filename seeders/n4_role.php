<?php
declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class N4Role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::transaction(function () {
            Db::table('role_basic')->insertOrIgnore([
                'name' => json_encode([
                    'zh_cn' => '超级管理员',
                    'en_us' => 'super'
                ], JSON_UNESCAPED_UNICODE),
                'key' => '*',
                'create_time' => time(),
                'update_time' => time()
            ]);

            $resource = Db::table('resource')
                ->get(['key'])
                ->map(function ($v) {
                    return [
                        'role_key' => '*',
                        'resource_key' => $v->key
                    ];
                });

            Db::table('role_resource')
                ->insertOrIgnore($resource->toArray());
        });
    }
}
