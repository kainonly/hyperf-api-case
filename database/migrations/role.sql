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
