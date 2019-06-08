import { JwtService } from '@nestjs/jwt';
import { Controller, Get, Post, Req, Request } from '@nestjs/common';
import { RouterService } from '../repository/router.service';
import { Payload } from '../common/payload';

@Controller('main')
export class MainController {
  constructor(
    private routerService: RouterService,
    private readonly jwtService: JwtService,
  ) {
  }

  @Post('login')
  login(@Req() req: any): any {
    const payload: Payload = {
      userId: 1,
      roleId: 1,
      symbol: {},
    };
    const token = this.jwtService.sign(payload);
    return {
      error: 0,
      data: token,
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
