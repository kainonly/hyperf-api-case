import { Column, Entity, JoinColumn, ManyToOne, PrimaryGeneratedColumn } from 'typeorm';
import { AdminEntity } from './admin.entity';
import { RoleEntity } from './role.entity';

@Entity('role_relations')
export class RoleRelationsEntity {
  @PrimaryGeneratedColumn({
    unsigned: true,
  })
  id?: number;

  @ManyToOne(type => AdminEntity, {
    onDelete: 'RESTRICT',
    onUpdate: 'RESTRICT',
  })
  @JoinColumn({
    name: 'admin',
    referencedColumnName: 'id',
  })
  admin: number;

  @ManyToOne(type => RoleEntity, {
    onDelete: 'RESTRICT',
    onUpdate: 'RESTRICT',
  })
  @JoinColumn({
    name: 'role',
    referencedColumnName: 'id',
  })
  role: number;

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
