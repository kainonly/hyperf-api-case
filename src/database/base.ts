import { Column, CreateDateColumn, PrimaryGeneratedColumn, UpdateDateColumn } from 'typeorm';

export abstract class Base {
  @PrimaryGeneratedColumn()
  id?: number;

  @Column('bool', {
    default: true,
    comment: '状态',
  })
  status?: boolean;

  @CreateDateColumn({
    comment: '创建时间',
  })
  create_time?: Date;

  @UpdateDateColumn({
    comment: '更新时间',
  })
  update_time?: number;
}
