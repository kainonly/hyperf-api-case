<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminBasicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_basic')->insert([
            'id' => 1,
            'username' => 'kain',
            'password' => Hash::make('123456'),
            'call' => 'kain',
            'create_time' => time(),
            'update_time' => time()
        ]);
    }
}
