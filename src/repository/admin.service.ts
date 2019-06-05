import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Curd } from '../common/curd';
import { Admin } from '../entity/admin';

@Injectable()
export class AdminService extends Curd {
  constructor(
    @InjectRepository(Admin)
    public readonly repository: Repository<Admin>,
  ) {
    super(repository);
  }
}
