<?php
declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;
use Hyperf\Extra\Hash\HashInterface;
use Hyperf\Utils\ApplicationContext;

class N6Admin extends Seeder
{
    private HashInterface $hash;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $container = ApplicationContext::getContainer();
        $this->hash = $container->get(HashInterface::class);
        Db::transaction(function () {
            $resultId = Db::table('admin')->insertGetId([
                'username' => 'kain',
                'password' => $this->hash->create('pass@VAN1234'),
                'call' => 'kain',
                'create_time' => time(),
                'update_time' => time()
            ]);

            Db::table('admin_role_rel')->insertOrIgnore([
                'admin_id' => $resultId,
                'role_key' => '*'
            ]);
        });
    }
}
