import { Controller, Get, Post } from '@nestjs/common';

@Controller('main')
export class MainController {
  @Get()
  index(): any {
    return [];
  }

  @Post('verify')
  verify(): any {
    return {
      error: 0,
    };
  }

  @Post('menu')
  menu(): any {
    return {
      error: 0,
      data: [],
    };
  }
}
