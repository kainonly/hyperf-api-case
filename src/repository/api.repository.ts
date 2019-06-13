import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { ApiEntity } from '../entity/api.entity';

@Injectable()
export class ApiRepository {
  constructor(
    @InjectRepository(ApiEntity)
    public readonly repository: Repository<ApiEntity>,
  ) {
  }
}
