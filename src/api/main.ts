import { Body, Controller, Get, Post, UsePipes } from '@nestjs/common';
import { AdminCache } from '../cache/admin.cache';
import { DbService } from '../common/db.service';
import { validate } from '../helper';

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

  @Post('menu')
  @UsePipes(validate({
    required: ['name'],
    properties: {
      name: {
        type: 'string',
      },
    },
  }))
  menu(@Body() body: any) {
    return {};
  }
}
