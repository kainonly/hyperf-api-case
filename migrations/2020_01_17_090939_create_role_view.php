<?php

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\Migration;

class CreateRoleView extends Migration
{
    private function table(string $name): string
    {
        return $this->prefix . $name;
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();
        $sql = "create view {$this->prefix}role as ";
        $sql .= "select rb.id,rb.`key`,rb.name,";
        $sql .= "group_concat(distinct rrr.resource_key separator ',') as resource,";
        $sql .= "group_concat(distinct concat(rp.acl_key, ':', rp.policy) separator ',') as acl,";
        $sql .= "rb.note,rb.status,rb.create_time,rb.update_time ";
        $sql .= "from {$this->prefix}role_basic rb ";
        $sql .= "left join {$this->prefix}role_resource_rel rrr on rb.`key` = rrr.role_key ";
        $sql .= "left join {$this->prefix}role_policy rp on rb.`key` = rp.role_key ";
        $sql .= "group by rb.id, rb.`key`, rb.name, rb.note, rb.status, rb.create_time, rb.update_time";
        Db::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::statement("drop view if exists {$this->prefix}role");
    }
}
