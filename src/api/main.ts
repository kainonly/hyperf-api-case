import { Body, Controller, Get, Post, Res, UsePipes } from '@nestjs/common';
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
  index() {
    return {};
  }

  @Get('setCookie')
  setCookie(@Res() res) {
    res.setCookie('test', 'xxx');
    res.send({});
  }

  @Get('getCookie')
  getCookie(@Cookie() cookie) {
    return cookie.test;
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
