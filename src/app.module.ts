import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';

import { IndexController } from './controller/index.controller';
import { MainController } from './controller/main.controller';

import { ConfigService } from './service/config.service';
import { RedisService } from './service/redis.service';

import { Router } from './entity/router';
import { User } from './entity/user';

import { RouterService } from './repository/router.service';

@Module({
  imports: [
    TypeOrmModule.forRoot(),
    TypeOrmModule.forFeature([
      Router,
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
    RouterService,
  ],
})
export class AppModule {
}
