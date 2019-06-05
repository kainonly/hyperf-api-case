import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Curd } from '../common/curd';
import { Api } from '../entity/api';

@Injectable()
export class ApiService extends Curd {
  constructor(
    @InjectRepository(Api)
    public readonly repository: Repository<Api>,
  ) {
    super(repository);
  }
}
