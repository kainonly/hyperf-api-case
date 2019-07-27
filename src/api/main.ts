import { Controller, Get } from '@nestjs/common';
import { DbService } from '../common/db.service';
import { AdminCache } from '../cache/admin.cache';

@Controller()
export class Main {
  constructor(
    private db: DbService,
    private adminCache: AdminCache,
  ) {
  }

  @Get()
  async index() {
    this.adminCache.refresh();
    return {
      status: 'ok',
    };
  }

  @Get('menu')
  async menu() {
    return;
  }
}
