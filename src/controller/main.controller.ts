import { Controller, Get } from '@nestjs/common';
import { ConfigService } from '../service/config.service';
import { RedisService } from '../service/redis.service';

@Controller('main')
export class MainController {
  constructor(
    private configService: ConfigService,
    private redisService: RedisService,
  ) {
  }

  @Get()
  index(): any {
    this.redisService.client.set('test', 1);
    return [];
  }
}
