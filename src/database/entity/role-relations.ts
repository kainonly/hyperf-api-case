import { Entity, JoinColumn, ManyToOne } from 'typeorm';
import { Base } from '../base';
import { Admin } from './admin';
import { Role } from './role';

@Entity()
export class RoleRelations extends Base {
  @ManyToOne(type => Admin, {
    onDelete: 'RESTRICT',
    onUpdate: 'RESTRICT',
  })
  @JoinColumn({
    name: 'admin',
    referencedColumnName: 'id',
  })
  admin: number;

  @ManyToOne(type => Role, {
    onDelete: 'RESTRICT',
    onUpdate: 'RESTRICT',
  })
  @JoinColumn({
    name: 'role',
    referencedColumnName: 'id',
  })
  role: number;
}
