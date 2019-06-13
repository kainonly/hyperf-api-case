import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { AdminEntity } from '../entity/admin.entity';

@Injectable()
export class AdminRepository {
  constructor(
    @InjectRepository(AdminEntity)
    public readonly repository: Repository<AdminEntity>,
  ) {
  }
}
