import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { RouterEntity } from '../database/router.entity';

@Injectable()
export class DbService {
  constructor(
    @InjectRepository(RouterEntity)
    public readonly router: Repository<RouterEntity>,
  ) {
  }

}
