import { Column, Entity, PrimaryGeneratedColumn } from 'typeorm';

@Entity()
export class Router {
  @PrimaryGeneratedColumn({
    unsigned: true,
  })
  id?: number;

  @Column('int', {
    unsigned: true,
    default: 0,
    comment: '父级关联',
  })
  parent?: number;

  @Column('longtext', {
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

  @Column('tinyint', {
    width: 1,
    unsigned: true,
    default: 0,
    comment: '排序',
  })
  sort?: number;

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
