<?php

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\Migration;

class CreateAdminPolicyMix extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();
        $sql = "create view {$this->prefix}admin_policy_mix as ";
        $sql .= "select arr.admin_id, p.acl_key, max(p.policy) as policy ";
        $sql .= "from {$this->prefix}admin_resource_rel arr ";
        $sql .= "join {$this->prefix}policy p on arr.resource_key = p.resource_key ";
        $sql .= "group by arr.admin_id, p.acl_key";
        Db::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::statement("drop view if exists {$this->prefix}admin_policy_mix");
    }
}
