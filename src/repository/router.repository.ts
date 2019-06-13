import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { RouterEntity } from '../entity/router.entity';

@Injectable()
export class RouterRepository {
  constructor(
    @InjectRepository(RouterEntity)
    public readonly repository: Repository<RouterEntity>,
  ) {
  }
}
