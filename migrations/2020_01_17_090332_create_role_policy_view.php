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
        Db::statement(
            "CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `{$this->prefix}role_policy` AS
                    select `{$this->prefix}role_resource`.`role_key` AS `role_key`,
                           `{$this->prefix}policy`.`acl_key`         AS `acl_key`,
                           max(`{$this->prefix}policy`.`policy`)     AS `policy`
                    from (`{$this->prefix}role_resource`
                             join `{$this->prefix}policy` on (`{$this->prefix}role_resource`.`resource_key` = `{$this->prefix}policy`.`resource_key` and
                                                 `{$this->prefix}role_resource`.`resource_key` = `{$this->prefix}policy`.`resource_key`))
                    group by `{$this->prefix}role_resource`.`role_key`, `{$this->prefix}policy`.`acl_key`;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::statement("DROP VIEW IF EXISTS `{$this->prefix}role_policy`;");
    }
}
