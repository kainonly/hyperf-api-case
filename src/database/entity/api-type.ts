import { Column, Entity } from 'typeorm';
import { Base } from '../base';

@Entity()
export class ApiType extends Base {
  @Column('json', {
    comment: '接口类型名称',
  })
  name: any;
}
