import { Controller, Get } from '@nestjs/common';
import { RouterService } from '../repository/router.service';

@Controller('main')
export class MainController {
  constructor(
    private routerService: RouterService,
  ) {
  }

  @Get('verify')
  verify(): any {
    return {
      error: 0,
    };
  }

  @Get('menu')
  menu(): any {
    return this.routerService.repository.find().then(data => {
      return {
        error: 0,
        data,
      };
    });
  }
}
