import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';

import { User } from './entity/user';

import { IndexController } from './controller/index.controller';
import { UserService } from './service/user.service';
import { MainController } from './controller/main.controller';

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
    UserService,
  ],
})
export class AppModule {
}
