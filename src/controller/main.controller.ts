import { Controller, Get } from '@nestjs/common';
import { DbService } from '../common/db.service';

@Controller()
export class MainController {
  constructor(
    private db: DbService,
  ) {
  }

  @Get()
  async index() {
    return await this.db.router.find();
  }

  @Get('menu')
  async menu() {
    return {
      error: 0,
    };
  }
}
