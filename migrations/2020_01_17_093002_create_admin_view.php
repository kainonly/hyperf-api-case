<?php

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\Migration;

class CreateAdminView extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();
        $sql = "create view {$this->prefix}admin as ";
        $sql .= "select ab.id,ab.username,ab.password,";
        $sql .= "group_concat(distinct arr.role_key separator ',') as role,";
        $sql .= "ab.`call`,ab.email, ab.phone,ab.avatar,ab.status,ab.create_time,ab.update_time ";
        $sql .= "from {$this->prefix}admin_basic ab ";
        $sql .= "join {$this->prefix}admin_role_rel arr on ab.id = arr.admin_id ";
        $sql .= "group by ab.id, ab.username, ab.password, ab.`call`, ab.email, ab.phone, ab.avatar, ab.status, ab.create_time, ab.update_time";
        Db::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::statement("drop view if exists {$this->prefix}admin");
    }
}
