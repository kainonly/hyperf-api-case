import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Curd } from '../common/curd';
import { Role } from '../entity/role';

@Injectable()
export class RoleService extends Curd {
  constructor(
    @InjectRepository(Role)
    public readonly repository: Repository<Role>,
  ) {
    super(repository);
  }
}
