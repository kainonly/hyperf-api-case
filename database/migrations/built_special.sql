use studio;
-- ----------------------------
-- View structure for v_role_policy
-- ----------------------------
DROP VIEW IF EXISTS `v_role_policy`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_role_policy` AS
select `v_role_resource`.`role_key` AS `role_key`,
       `v_policy`.`acl_key`         AS `acl_key`,
       max(`v_policy`.`policy`)     AS `policy`
from (`v_role_resource`
         join `v_policy` on (`v_role_resource`.`resource_key` = `v_policy`.`resource_key` and
                             `v_role_resource`.`resource_key` = `v_policy`.`resource_key`))
group by `v_role_resource`.`role_key`, `v_policy`.`acl_key`;


-- ----------------------------
-- View structure for v_role
-- ----------------------------
DROP VIEW IF EXISTS `v_role`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_role` AS
select `v_role_basic`.`id`                                                                                   AS `id`,
       `v_role_basic`.`key`                                                                                  AS `key`,
       `v_role_basic`.`name`                                                                                 AS `name`,
       group_concat(distinct `v_role_resource`.`resource_key` separator ',')                                 AS `resource`,
       group_concat(distinct concat(`v_role_policy`.`acl_key`, ':', `v_role_policy`.`policy`) separator ',') AS `acl`,
       `v_role_basic`.`note`                                                                                 AS `note`,
       `v_role_basic`.`status`                                                                               AS `status`,
       `v_role_basic`.`create_time`                                                                          AS `create_time`,
       `v_role_basic`.`update_time`                                                                          AS `update_time`
from ((`v_role_basic` left join `v_role_resource` on (`v_role_resource`.`role_key` = `v_role_basic`.`key`))
         left join `v_role_policy` on (`v_role_basic`.`key` = `v_role_policy`.`role_key`))
group by `v_role_basic`.`id`, `v_role_basic`.`key`, `v_role_basic`.`name`, `v_role_basic`.`note`,
         `v_role_basic`.`status`, `v_role_basic`.`create_time`, `v_role_basic`.`update_time`;

-- ----------------------------
-- View structure for v_admin
-- ----------------------------
DROP VIEW IF EXISTS `v_admin`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `v_admin` AS
select `v_admin_basic`.`id`                                           AS `id`,
       `v_admin_basic`.`username`                                     AS `username`,
       `v_admin_basic`.`password`                                     AS `password`,
       group_concat(distinct `v_admin_role`.`role_key` separator ',') AS `role`,
       `v_admin_basic`.`call`                                         AS `call`,
       `v_admin_basic`.`email`                                        AS `email`,
       `v_admin_basic`.`phone`                                        AS `phone`,
       `v_admin_basic`.`avatar`                                       AS `avatar`,
       `v_admin_basic`.`status`                                       AS `status`,
       `v_admin_basic`.`create_time`                                  AS `create_time`,
       `v_admin_basic`.`update_time`                                  AS `update_time`
from (`v_admin_basic`
         join `v_admin_role` on (`v_admin_role`.`admin_id` = `v_admin_basic`.`id`))
group by `v_admin_basic`.`id`, `v_admin_basic`.`username`, `v_admin_basic`.`password`, `v_admin_basic`.`call`,
         `v_admin_basic`.`email`, `v_admin_basic`.`phone`, `v_admin_basic`.`avatar`, `v_admin_basic`.`status`,
         `v_admin_basic`.`create_time`, `v_admin_basic`.`update_time`;
