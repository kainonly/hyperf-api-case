import { Column, Entity } from 'typeorm';
import { Base } from '../base';

@Entity()
export class Router extends Base {
  @Column('int8', {
    default: 0,
    comment: '父级关联',
  })
  parent?: number;

  @Column('json', {
    comment: '路由名称',
  })
  name: any;

  @Column('bool', {
    default: false,
    comment: '是否为导航',
  })
  nav?: boolean;

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
