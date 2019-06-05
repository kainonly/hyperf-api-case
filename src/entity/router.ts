import { Column, Entity, PrimaryGeneratedColumn } from 'typeorm';
import { I18n } from '../type';

@Entity()
export class Router {
  /**
   * 主键
   */
  @PrimaryGeneratedColumn()
  id?: number;

  /**
   * 父级关联
   */
  @Column('int4', { default: 0 })
  parent?: number;

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
   * 是否为导航
   */
  @Column('bool', { default: false })
  nav?: boolean;

  /**
   * 字体图标
   */
  @Column('varchar', { length: 50, nullable: true })
  icon?: string;

  /**
   * 路由地址
   */
  @Column('varchar', { length: 90 })
  routerlink: string;

  /**
   * 排序
   */
  @Column('int2', { default: 0 })
  sort?: number;

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
