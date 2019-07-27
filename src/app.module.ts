import { Module } from '@nestjs/common';
import { DbModule } from './database/db.module';
import { DbService } from './facade/db.service';
import { RedisService } from './facade/redis.service';

import { Main } from './api/main';
import { ConfigService } from './facade/config.service';

@Module({
  imports: [
    DbModule,
  ],
  controllers: [
    Main,
  ],
  providers: [
    ConfigService,
    DbService,
    RedisService,
  ],
})
export class AppModule {
}
