# Your Database
use studio;
# Admin View
CREATE OR REPLACE VIEW `studio`.`v_admin` AS
SELECT `v_admin_basic`.`id`                                           AS `id`,
       `v_admin_basic`.`username`                                     AS `username`,
       `v_admin_basic`.`password`                                     AS `password`,
       group_concat(DISTINCT `v_admin_role`.`role_key` SEPARATOR ',') AS `role`,
       `v_admin_basic`.`call`                                         AS `call`,
       `v_admin_basic`.`status`                                       AS `status`,
       `v_admin_basic`.`create_time`                                  AS `create_time`,
       `v_admin_basic`.`update_time`                                  AS `update_time`
FROM (
      `v_admin_basic`
         JOIN `v_admin_role` ON (`v_admin_role`.`admin_id` = `v_admin_basic`.`id`))
GROUP BY `v_admin_basic`.`id`,
         `v_admin_basic`.`username`,
         `v_admin_basic`.`password`,
         `v_admin_basic`.`call`,
         `v_admin_basic`.`status`,
         `v_admin_basic`.`create_time`,
         `v_admin_basic`.`update_time`;
