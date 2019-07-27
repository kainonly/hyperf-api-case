import { Column, Entity, JoinColumn, ManyToOne, PrimaryGeneratedColumn } from 'typeorm';
import { ApiTypeEntity } from './api-type.entity';

@Entity('role')
export class RoleEntity {
  @PrimaryGeneratedColumn({
    unsigned: true,
  })
  id?: number;

  @Column('json', {
    comment: '权限组名称',
  })
  name: string;

  @Column('int', {
    unsigned: true,
    default: 0,
    comment: '权限组父级',
  })
  parent?: number;

  @Column('json', {
    comment: '授权路由',
  })
  access_router: string;

  @Column('json', {
    comment: '授权接口',
  })
  access_api: string;

  @Column('text', {
    nullable: true,
    comment: '备注',
  })
  note?: string;

  @Column('tinyint', {
    width: 1,
    unsigned: true,
    default: 1,
    comment: '状态',
  })
  status?: number;

  @Column('int', {
    width: 10,
    unsigned: true,
    default: 0,
    comment: '创建时间',
  })
  create_time?: number;

  @Column('int', {
    width: 10,
    unsigned: true,
    default: 0,
    comment: '更新时间',
  })
  update_time?: number;
}
