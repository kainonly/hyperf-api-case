<?php

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\Migration;

class CreateAdminMix extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();
        $sql = "create view {$this->prefix}admin_mix as ";
        $sql .= "select a.id,a.username,a.password,";
        $sql .= "group_concat(distinct arr.role_key separator ',') as role,";
        $sql .= "a.permission, a.`call`,a.email, a.phone,a.avatar,a.status,a.create_time,a.update_time ";
        $sql .= "from {$this->prefix}admin a ";
        $sql .= "join {$this->prefix}admin_role_rel arr on a.id = arr.admin_id ";
        $sql .= "group by a.id, a.username, a.password, a.permission, a.`call`, a.email, a.phone, a.avatar, a.status, a.create_time, a.update_time";
        Db::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::statement("drop view if exists {$this->prefix}admin_mix");
    }
}
