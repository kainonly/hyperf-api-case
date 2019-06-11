import { Controller, Get } from '@nestjs/common';
import { RouterService } from '../repository/router.service';

@Controller('main')
export class MainController {
  constructor(
    private routerService: RouterService,
  ) {
  }

  // @Post('login')
  // login(@Req() req: any): any {
  //   const payload: Payload = {
  //     userId: 1,
  //     roleId: 1,
  //     symbol: {},
  //   };
  //   const token = this.jwtService.sign(payload);
  //   return {
  //     error: 0,
  //     data: token,
  //   };
  // }

  @Get('menu')
  async menu(): Promise<any> {
    const data = await this.routerService.repository.find();
    return {
      error: 0,
      data,
    };
  }
}
