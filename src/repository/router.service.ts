import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Curd } from '../common/curd';
import { Router } from '../entity/router';

@Injectable()
export class RouterService extends Curd {
  constructor(
    @InjectRepository(Router)
    public readonly repository: Repository<Router>,
  ) {
    super(repository);
  }
}
