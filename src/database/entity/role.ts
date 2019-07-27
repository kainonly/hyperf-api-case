import { Column, Entity } from 'typeorm';
import { CommonEntity } from '../common.entity';

@Entity()
export class Role extends CommonEntity {
  @Column('json', {
    comment: '权限组名称',
  })
  name: string;

  @Column('int', {
    unsigned: true,
    default: 0,
    comment: '权限组父级',
  })
  parent?: number;

  @Column('json', {
    comment: '授权路由',
  })
  access_router: string;

  @Column('json', {
    comment: '授权接口',
  })
  access_api: string;

  @Column('text', {
    nullable: true,
    comment: '备注',
  })
  note?: string;
}
