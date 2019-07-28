import { Body, Controller, Get, Next, Post, Response, UsePipes } from '@nestjs/common';
import { AdminCache } from '../cache/admin.cache';
import { DbService } from '../common/db.service';
import { Cookie, validate } from '../helper';

@Controller()
export class Main {
  constructor(
    private db: DbService,
    private adminCache: AdminCache,
  ) {
  }

  @Get()
  async index(@Next() next: any) {
  }

  @Get('menu')
  menu(@Body() body: any) {
    return {};
  }
}
