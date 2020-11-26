<?php

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\Migration;

class CreateRolePolicyView extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();
        $sql = "create view {$this->prefix}role_policy as ";
        $sql .= "select rrr.role_key, p.acl_key, max(p.policy) as policy ";
        $sql .= "from {$this->prefix}role_resource_rel rrr ";
        $sql .= "join {$this->prefix}policy p on rrr.resource_key = p.resource_key ";
        $sql .= "group by rrr.role_key, p.acl_key";
        Db::statement($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::statement("drop view if exists {$this->prefix}role_policy");
    }
}
