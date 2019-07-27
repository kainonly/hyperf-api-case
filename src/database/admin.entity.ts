import { Column, Entity, PrimaryGeneratedColumn } from 'typeorm';

@Entity('admin')
export class AdminEntity {
  @PrimaryGeneratedColumn({
    unsigned: true,
  })
  id?: number;

  @Column('varchar', {
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
  create_time?: number;

  @Column('int', {
    width: 10,
    unsigned: true,
    default: 0,
    comment: '更新时间',
  })
  update_time?: number;
}
