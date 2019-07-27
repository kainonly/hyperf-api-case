import { Module } from '@nestjs/common';
import { DbModule } from './database/db.module';

import { ConfigService } from './common/config.service';
import { DbService } from './common/db.service';
import { RedisService } from './common/redis.service';

import { Main } from './api/main';
import { AdminCache } from './cache/admin.cache';

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
    AdminCache,
  ],
})
export class AppModule {
}
