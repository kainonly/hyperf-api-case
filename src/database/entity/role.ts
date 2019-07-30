import { Column, Entity } from 'typeorm';
import { Base } from '../base';

@Entity()
export class Role extends Base {
  @Column('json', {
    comment: '权限组名称',
  })
  name: string;

  @Column('json', {
    comment: '授权路由',
  })
  access_router: any;

  @Column('json', {
    comment: '授权接口',
  })
  access_api: any;

  @Column('text', {
    nullable: true,
    comment: '备注',
  })
  note?: string;
}
