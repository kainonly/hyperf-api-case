import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { ApiTypeEntity } from '../entity/api-type.entity';

@Injectable()
export class ApiTypeRepository {
  constructor(
    @InjectRepository(ApiTypeEntity)
    public readonly repository: Repository<ApiTypeEntity>,
  ) {
  }
}
