<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleAclTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $acl = DB::table('acl')
            ->get(['key'])
            ->map(function ($v) {
                return [
                    'role_key' => '*',
                    'acl_key' => $v['key'],
                    'policy' => 'rw'
                ];
            });

        DB::table('role_acl')
            ->insert($acl->toArray());
    }
}
