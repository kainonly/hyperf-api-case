import { Column, Entity, PrimaryGeneratedColumn } from 'typeorm';

@Entity()
export class Router {
  @PrimaryGeneratedColumn()
  id?: number;

  @Column('int8')
  parent?: number;

  @Column('json')
  name: {
    zh_cn: string,
    en_us?: string
  };

  @Column('bool')
  nav?: boolean;

  @Column('varchar')
  icon?: string;

  @Column('varchar')
  routerlink: string;

  @Column('int2')
  sort?: number;

  @Column('bool')
  status?: boolean;

  @Column('timestamptz')
  create_time: Date;

  @Column('timestamptz')
  update_time: Date;
}
