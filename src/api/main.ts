import { Controller, Get } from '@nestjs/common';
import { DbService } from '../facade/db.service';

@Controller()
export class Main {
  constructor(
    private db: DbService,
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
