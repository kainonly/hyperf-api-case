import { Controller, Get } from '@nestjs/common';
import { ConfigService } from '../service/config.service';

@Controller('main')
export class MainController {
  constructor(
    private configService: ConfigService,
  ) {
  }

  @Get()
  index(): any {
    return this.configService.get('redis_db');
  }
}
