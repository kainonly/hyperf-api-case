import { Column, Entity, PrimaryGeneratedColumn } from 'typeorm';

@Entity()
export class Role {
  @PrimaryGeneratedColumn({
    unsigned: true,
  })
  id?: number;

  @Column('longtext', {
    comment: '路由名称',
  })
  name: string;

  @Column('blob', {
    comment: '授权路由集合',
  })
  router: any;

  @Column('blob', {
    comment: '授权接口集合',
  })
  api: any;

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
