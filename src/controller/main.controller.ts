import { Controller, Get, Post } from '@nestjs/common';
import { RouterService } from '../repository/router.service';

@Controller('main')
export class MainController {
  constructor(
    private routerService: RouterService,
  ) {
  }

  @Post('login')
  login(): any {
    return {
      error: 0,
    };
  }

  @Get('verify')
  verify(): any {
    return {
      error: 0,
    };
  }

  @Get('menu')
  menu(): any {
    return this.routerService.repository
      .find()
      .then(data => ({
        error: 0,
        data,
      }));
  }
}
