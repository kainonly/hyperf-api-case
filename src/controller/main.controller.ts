import { Controller, Get, Post, Req, Res } from '@nestjs/common';
import { RouterService } from '../repository/router.service';
import { RedisService } from '../service/redis.service';
import { JwtService } from '@nestjs/jwt';
import { Payload } from '../common/payload';

@Controller('main')
export class MainController {
  constructor(
    private jwtService: JwtService,
    private redisService: RedisService,
    private routerService: RouterService,
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

  @Get('menu')
  async menu() {
    const data = await this.routerService.repository.find();
    return {
      error: 0,
      data,
    };
  }
}
