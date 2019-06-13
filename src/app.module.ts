import { Module } from '@nestjs/common';
import { JwtModule } from '@nestjs/jwt';
import { config } from 'dotenv';

const env = config().parsed;

import { AppModelModule } from './app-repository.module';

import { MainController } from './controller/main.controller';

import { ConfigService } from './common/config.service';
import { RedisService } from './common/redis.service';
import { AuthService } from './common/auth.service';
import { CurdService } from './common/curd.service';

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
    {
      provide: ConfigService,
      useValue: {
        env,
      },
    },
    RedisService,
    AuthService,
    CurdService,
  ],
})
export class AppModule {
}
