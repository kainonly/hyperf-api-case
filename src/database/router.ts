import { Column, Entity } from 'typeorm';
import { BaseEntity } from '../common/base.entity';

@Entity()
export class Router extends BaseEntity {
  @Column('int', {
    unsigned: true,
    default: 0,
    comment: '父级关联',
  })
  parent?: number;

  @Column('json', {
    comment: '路由名称',
  })
  name: string;

  @Column('tinyint', {
    width: 1,
    unsigned: true,
    default: 0,
    comment: '是否为导航',
  })
  nav?: number;

  @Column('varchar', {
    length: 50,
    nullable: true,
    comment: '字体图标',
  })
  icon?: string;

  @Column('varchar', {
    length: 90,
    comment: '路由地址',
  })
  routerlink: string;
}
