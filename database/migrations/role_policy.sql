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
