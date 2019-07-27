import { Controller, Get } from '@nestjs/common';
import { AdminCache } from '../cache/admin.cache';
import { DbService } from '../common/db.service';

@Controller()
export class Main {

  constructor(
    private db: DbService,
    private adminCache: AdminCache,
  ) {
  }

  @Get()
  async index() {
    return {
      status: 'ok',
    };
  }

  @Get('menu')
  async menu() {
    return;
  }
}
