# Your Database
USE studio;
# Role View
CREATE OR REPLACE VIEW `studio`.`v_role` AS
SELECT `v_role_basic`.`id`                                                                             AS `id`,
       `v_role_basic`.`key`                                                                            AS `key`,
       `v_role_basic`.`name`                                                                           AS `name`,
       group_concat(DISTINCT concat(`v_role_acl`.`acl_key`, ':', `v_role_acl`.`policy`) SEPARATOR ',') AS `acl`,
       group_concat(DISTINCT `v_role_resource`.`resource_key` SEPARATOR ',')                           AS `resource`,
       `v_role_basic`.`note`                                                                           AS `note`,
       `v_role_basic`.`status`                                                                         AS `status`,
       `v_role_basic`.`create_time`                                                                    AS `create_time`,
       `v_role_basic`.`update_time`                                                                    AS `update_time`
FROM ((
          `v_role_basic`
              JOIN `v_role_acl` ON (`v_role_acl`.`role_key` = `v_role_basic`.`key`))
         JOIN `v_role_resource` ON (`v_role_resource`.`role_key` = `v_role_basic`.`key`))
GROUP BY `v_role_basic`.`id`,
         `v_role_basic`.`key`,
         `v_role_basic`.`name`,
         `v_role_basic`.`note`,
         `v_role_basic`.`status`,
         `v_role_basic`.`create_time`,
         `v_role_basic`.`update_time`;
