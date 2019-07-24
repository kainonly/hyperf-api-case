import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';

import { DbService } from './common/db.service';

import { RouterEntity } from './database/router.entity';

import { MainController } from './controller/main.controller';

@Module({
  imports: [
    TypeOrmModule.forRoot(),
    TypeOrmModule.forFeature([
      RouterEntity,
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
