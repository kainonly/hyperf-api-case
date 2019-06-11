import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';

import { MainController } from './controller/main.controller';

import { Router } from './entity/router';

import { RouterService } from './repository/router.service';
import { ConfigService } from './service/config.service';

@Module({
  imports: [
    TypeOrmModule.forRoot(),
    TypeOrmModule.forFeature([
      Router,
    ]),
  ],
  controllers: [
    MainController,
  ],
  providers: [
    ConfigService,
    RouterService,
  ],
})
export class AppModule {
}
