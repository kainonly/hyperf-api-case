import { Column, Entity } from 'typeorm';
import { Base } from '../base';

@Entity()
export class Admin extends Base {
  @Column('varchar', {
    length: 30,
    unique: true,
    comment: '用户名称',
  })
  username: string;

  @Column('text', {
    comment: '用户密码',
  })
  password: string;

  @Column('varchar', {
    length: 20,
    nullable: true,
    comment: '称呼',
  })
  call: string;

  @Column('varchar', {
    length: 20,
    nullable: true,
    comment: '手机号',
  })
  phone?: string;

  @Column('varchar', {
    length: 50,
    nullable: true,
    comment: '电子邮件',
  })
  email?: string;

  @Column('text', {
    nullable: true,
    comment: '头像地址',
  })
  avatar?: string;
}
