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
