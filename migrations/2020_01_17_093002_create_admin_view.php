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
        Db::statement(
            "CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `{$this->prefix}admin` AS
                    select `{$this->prefix}admin_basic`.`id`                                           AS `id`,
                           `{$this->prefix}admin_basic`.`username`                                     AS `username`,
                           `{$this->prefix}admin_basic`.`password`                                     AS `password`,
                           group_concat(distinct `{$this->prefix}admin_role`.`role_key` separator ',') AS `role`,
                           `{$this->prefix}admin_basic`.`call`                                         AS `call`,
                           `{$this->prefix}admin_basic`.`email`                                        AS `email`,
                           `{$this->prefix}admin_basic`.`phone`                                        AS `phone`,
                           `{$this->prefix}admin_basic`.`avatar`                                       AS `avatar`,
                           `{$this->prefix}admin_basic`.`status`                                       AS `status`,
                           `{$this->prefix}admin_basic`.`create_time`                                  AS `create_time`,
                           `{$this->prefix}admin_basic`.`update_time`                                  AS `update_time`
                    from (`{$this->prefix}admin_basic`
                             join `{$this->prefix}admin_role` on (`{$this->prefix}admin_role`.`admin_id` = `{$this->prefix}admin_basic`.`id`))
                    group by `{$this->prefix}admin_basic`.`id`, `{$this->prefix}admin_basic`.`username`, `{$this->prefix}admin_basic`.`password`, `{$this->prefix}admin_basic`.`call`,
                             `{$this->prefix}admin_basic`.`email`, `{$this->prefix}admin_basic`.`phone`, `{$this->prefix}admin_basic`.`avatar`, `{$this->prefix}admin_basic`.`status`,
                             `{$this->prefix}admin_basic`.`create_time`, `{$this->prefix}admin_basic`.`update_time`;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Db::statement("DROP VIEW IF EXISTS `{$this->prefix}admin`;");
    }
}
