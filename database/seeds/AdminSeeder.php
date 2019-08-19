<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $resultId = DB::table('admin_basic')->insertGetId([
                'username' => 'kain',
                'password' => Hash::make('123456'),
                'call' => 'kain',
                'create_time' => time(),
                'update_time' => time()
            ]);

            DB::table('admin_role')->insert([
                'admin_id' => $resultId,
                'role_key' => '*'
            ]);
        });

        (new \App\Http\System\Redis\Admin())->refresh();
    }
}
