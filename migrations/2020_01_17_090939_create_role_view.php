<?php

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\Migration;

class CreateRoleView extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();
        Db::statement(
            "CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `{$this->prefix}role` AS
                    select `{$this->prefix}role_basic`.`id`                                                                                   AS `id`,
                           `{$this->prefix}role_basic`.`key`                                                                                  AS `key`,
                           `{$this->prefix}role_basic`.`name`                                                                                 AS `name`,
                           group_concat(distinct `{$this->prefix}role_resource`.`resource_key` separator ',')                                 AS `resource`,
                           group_concat(distinct concat(`{$this->prefix}role_policy`.`acl_key`, ':', `{$this->prefix}role_policy`.`policy`) separator ',') AS `acl`,
                           `{$this->prefix}role_basic`.`note`                                                                                 AS `note`,
                           `{$this->prefix}role_basic`.`status`                                                                               AS `status`,
                           `{$this->prefix}role_basic`.`create_time`                                                                          AS `create_time`,
                           `{$this->prefix}role_basic`.`update_time`                                                                          AS `update_time`
                    from ((`{$this->prefix}role_basic` left join `{$this->prefix}role_resource` on (`{$this->prefix}role_resource`.`role_key` = `{$this->prefix}role_basic`.`key`))
                             left join `{$this->prefix}role_policy` on (`{$this->prefix}role_basic`.`key` = `{$this->prefix}role_policy`.`role_key`))
                    group by `{$this->prefix}role_basic`.`id`, `{$this->prefix}role_basic`.`key`, `{$this->prefix}role_basic`.`name`, `{$this->prefix}role_basic`.`note`,
                             `{$this->prefix}role_basic`.`status`, `{$this->prefix}role_basic`.`create_time`, `{$this->prefix}role_basic`.`update_time`;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::statement("DROP VIEW IF EXISTS `{$this->prefix}role`;");
    }
}
