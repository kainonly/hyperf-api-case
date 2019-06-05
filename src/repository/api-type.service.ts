import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Curd } from '../common/curd';
import { ApiType } from '../entity/api-type';

@Injectable()
export class ApiTypeService extends Curd {
  constructor(
    @InjectRepository(ApiType)
    public readonly repository: Repository<ApiType>,
  ) {
    super(repository);
  }
}
