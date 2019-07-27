import { Column, Entity } from 'typeorm';
import { CommonEntity } from '../common.entity';

@Entity()
export class ApiType extends CommonEntity {
  @Column('json', {
    comment: '接口类型名称',
  })
  name: string;
}
