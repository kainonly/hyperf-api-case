import { Column, Entity, PrimaryGeneratedColumn } from 'typeorm';

@Entity()
export class Router {
  @PrimaryGeneratedColumn()
  id: number;

  @Column('int')
  parent: number;

  @Column('longtext')
  name: string;

  @Column('tinyint')
  nav: number;

  @Column()
  icon: string;

  @Column()
  routerlink: string;

  @Column()
  sort: number;

  @Column()
  status: number;

  @Column()
  createTime: number;

  @Column()
  updateTime: number;
}
