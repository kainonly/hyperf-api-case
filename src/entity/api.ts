import { Column, Entity, JoinColumn, OneToOne, PrimaryGeneratedColumn } from 'typeorm';
import { ApiType } from './api-type';

@Entity()
export class Api {
  /**
   * 主键
   */
  @PrimaryGeneratedColumn()
  id?: number;

  /**
   * 接口类型外键
   */
  @OneToOne(type => ApiType, table => table.id, {
    onDelete: 'RESTRICT',
    onUpdate: 'RESTRICT',
  })
  @JoinColumn()
  type: number;

  /**
   * 路由名称
   */
  @Column('varchar', { length: '20' })
  name: string;

  /**
   * 状态
   */
  @Column('bool', { default: true })
  status?: boolean;

  /**
   * 创建时间
   */
  @Column('timestamptz')
  create_time: Date;

  /**
   * 更新时间
   */
  @Column('timestamptz')
  update_time: Date;
}
