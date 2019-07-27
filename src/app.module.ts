import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';

import { DbService } from './common/db.service';
import { Router } from './database/entity/router.entity';
import { MainController } from './controller/main.controller';

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
    DbService,
  ],
})
export class AppModule {
}
