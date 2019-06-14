import { Module } from '@nestjs/common';
import { JwtModule } from '@nestjs/jwt';
import { config } from 'dotenv';

import { AppModelModule } from './app-model.module';

import { MainController } from './controller/main.controller';

import { RedisService } from './common/redis.service';
import { AuthService } from './common/auth.service';
import { CurdService } from './common/curd.service';

const env: any = config().parsed;

@Module({
  imports: [
    AppModelModule,
    JwtModule.register({
      secretOrPrivateKey: env.SECRET_KEY,
      signOptions: {
        expiresIn: 3600,
      },
    }),
  ],
  controllers: [
    MainController,
  ],
  providers: [
    RedisService,
    AuthService,
    CurdService,
  ],
})
export class AppModule {
}
