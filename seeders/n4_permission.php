<?php
declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class N4Permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Db::table('permission')->insertOrIgnore([
            [
                'key' => 'privacy',
                'name' => json_encode([
                    'zh_cn' => '数据脱敏',
                    'en_us' => 'Privacy'
                ]),
                'note' => '用于隐私数据脱敏处理的标识'
            ],
            [
                'key' => 'check',
                'name' => json_encode([
                    'zh_cn' => '专用审核',
                    'en_us' => 'Check'
                ]),
                'note' => '用于少于拥有专用审核处理的标识'
            ]
        ]);
    }
}
