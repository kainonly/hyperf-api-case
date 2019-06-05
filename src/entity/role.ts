import { Column, Entity, PrimaryGeneratedColumn } from 'typeorm';
import { I18n } from '../common/type';

@Entity()
export class Role {
  /**
   * 主键
   */
  @PrimaryGeneratedColumn()
  id?: number;

  /**
   * 路由名称
   */
  @Column('json', {
    default: {
      zh_cn: '',
      en_us: '',
    },
  })
  name: I18n;

  /**
   * 授权路由集合
   */
  @Column('bytea')
  router: any;

  /**
   * 授权接口集合
   */
  @Column('bytea')
  api: any;

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
