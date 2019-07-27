import { Column, Entity, JoinColumn, ManyToOne, PrimaryGeneratedColumn } from 'typeorm';
import { ApiTypeEntity } from './api-type.entity';

@Entity('api')
export class ApiEntity {
  @PrimaryGeneratedColumn({
    unsigned: true,
  })
  id?: number;

  @ManyToOne(type => ApiTypeEntity, {
    onDelete: 'RESTRICT',
    onUpdate: 'RESTRICT',
  })
  @JoinColumn({
    name: 'type',
    referencedColumnName: 'id',
  })
  type: number;

  @Column('json', {
    comment: '接口名称',
  })
  name: string;

  @Column('varchar', {
    length: 90,
    unique: true,
    comment: '接口地址',
  })
  api: string;

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
