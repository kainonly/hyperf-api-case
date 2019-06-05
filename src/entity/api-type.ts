import { Column, Entity, PrimaryGeneratedColumn } from 'typeorm';
import { I18n } from '../type';

@Entity()
export class ApiType {
  /**
   * 主键
   */
  @PrimaryGeneratedColumn()
  id?: number;

  /**
   * 路由名称
   */
  @Column('varchar', { length: '20' })
  name: I18n;

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
