import { Column, Entity, JoinColumn, OneToOne, PrimaryGeneratedColumn } from 'typeorm';
import { ApiTypeEntity } from './api-type.entity';

@Entity('api')
export class ApiEntity {
  @PrimaryGeneratedColumn({
    unsigned: true,
  })
  id?: number;

  @OneToOne(type => ApiTypeEntity, table => table.id, {
    onUpdate: 'RESTRICT',
    onDelete: 'RESTRICT',
  })
  @JoinColumn({ name: 'type' })
  type: number;

  @Column('varchar', {
    length: 20,
    comment: '路由名称',
  })
  name: string;

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
  create_time: number;

  @Column('int', {
    width: 10,
    unsigned: true,
    default: 0,
    comment: '更新时间',
  })
  update_time: number;
}
