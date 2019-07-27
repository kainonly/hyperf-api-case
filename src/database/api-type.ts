import { Column, Entity } from 'typeorm';
import { BaseEntity } from '../common/base.entity';

@Entity()
export class ApiType extends BaseEntity {
  @Column('json', {
    comment: '接口类型名称',
  })
  name: string;
}
