<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleResourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resource = DB::table('resource')
            ->get(['key'])
            ->map(function ($v) {
                return [
                    'role_key' => '*',
                    'resource_key' => $v['key']
                ];
            });

        DB::table('role_resource')
            ->insert($resource->toArray());
    }
}
