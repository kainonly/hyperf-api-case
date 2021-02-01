<?php

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\Migration;

class CreateRoleMix extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();
        $sql = "create view {$this->prefix}role_mix as ";
        $sql .= "select r.id,r.`key`,r.name,";
        $sql .= "group_concat(distinct rrr.resource_key separator ',') as resource,";
        $sql .= "group_concat(distinct concat(rpm.acl_key, ':', rpm.policy) separator ',') as acl,";
        $sql .= "r.permission,r.note,r.status,r.create_time,r.update_time ";
        $sql .= "from {$this->prefix}role r ";
        $sql .= "left join {$this->prefix}role_resource_rel rrr on r.`key` = rrr.role_key ";
        $sql .= "left join {$this->prefix}role_policy_mix rpm on r.`key` = rpm.role_key ";
        $sql .= "group by r.id, r.`key`, r.name, r.permission, r.note, r.status, r.create_time, r.update_time";
        Db::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::statement("drop view if exists {$this->prefix}role_mix");
    }
}
