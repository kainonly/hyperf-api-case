import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Router } from '../database/entity/router.entity';

@Injectable()
export class DbService {
  constructor(
    @InjectRepository(Router)
    public readonly router: Repository<Router>,
  ) {
  }

}
