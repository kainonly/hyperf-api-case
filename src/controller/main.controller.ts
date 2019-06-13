import { Controller, Get, Post } from '@nestjs/common';

@Controller('main')
export class MainController {
  @Post('login')
  login(): any {
    return {
      error: 0,
    };
  }

  @Get('menu')
  async menu() {
    return {
      error: 0,
    };
  }
}
