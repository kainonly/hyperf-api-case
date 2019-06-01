import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';

import { User } from './entity/user';
import { IndexController } from './controller/index.controller';
import { MainController } from './controller/main.controller';
import { ConfigService } from './service/config.service';
import { RedisService } from './service/redis.service';

@Module({
  imports: [
    TypeOrmModule.forRoot(),
    TypeOrmModule.forFeature([
      User,
    ]),
  ],
  controllers: [
    IndexController,
    MainController,
  ],
  providers: [
    ConfigService,
    RedisService,
  ],
})
export class AppModule {
}
