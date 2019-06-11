import { Column, Entity, PrimaryGeneratedColumn } from 'typeorm';

@Entity()
export class Admin {
  /**
   * 主键
   */
  @PrimaryGeneratedColumn()
  id?: number;

  /**
   * 用户名
   */
  @Column('varchar', { length: 20, unique: true })
  username: string;

  /**
   * 密码
   */
  @Column('text')
  password: string;

  /**
   * 称呼
   */
  @Column('varchar', { length: 10, nullable: true })
  call?: string;

  /**
   * 手机号
   */
  @Column('char', { length: 11, nullable: true })
  phone?: string;

  /**
   * 电子邮件
   */
  @Column('varchar', { length: 60, nullable: true })
  email?: string;

  /**
   * 头像
   */
  @Column('text')
  avatar?: string;

  /**
   * 状态
   */
  @Column('bool', { default: true })
  status?: boolean;

  /**
   * 创建时间
   */
  @Column('timestamptz')
  create_time: Date;

  /**
   * 更新时间
   */
  @Column('timestamptz')
  update_time: Date;
}
