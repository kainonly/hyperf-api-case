import { JwtModule } from '@nestjs/jwt';
import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';

import { MainController } from './controller/main.controller';

import { Router } from './entity/router';
import { Api } from './entity/api';
import { ApiType } from './entity/api-type';
import { Role } from './entity/role';
import { Admin } from './entity/admin';

import { RouterService } from './repository/router.service';
import { AdminService } from './repository/admin.service';
import { ApiService } from './repository/api.service';
import { ApiTypeService } from './repository/api-type.service';
import { RoleService } from './repository/role.service';
import { ConfigService } from './service/config.service';
import { RedisService } from './service/redis.service';

@Module({
  imports: [
    JwtModule.register({
      secretOrPrivateKey: '88rOozRpg79ts6s5',
      signOptions: {
        expiresIn: 3600,
      },
    }),
    TypeOrmModule.forRoot(),
    TypeOrmModule.forFeature([
      Api,
      ApiType,
      Router,
      Role,
      Admin,
    ]),
  ],
  controllers: [
    MainController,
  ],
  providers: [
    ConfigService,
    RedisService,
    ApiService,
    ApiTypeService,
    RouterService,
    RoleService,
    AdminService,
  ],
})
export class AppModule {
}
