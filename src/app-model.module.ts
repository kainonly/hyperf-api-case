import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { ApiEntity } from './entity/api.entity';

import { ApiTypeEntity } from './entity/api-type.entity';
import { RouterEntity } from './entity/router.entity';
import { RoleEntity } from './entity/role.entity';
import { AdminEntity } from './entity/admin.entity';

@Module({
  imports: [
    TypeOrmModule.forRoot(),
    TypeOrmModule.forFeature([
      ApiEntity,
      ApiTypeEntity,
      RouterEntity,
      RoleEntity,
      AdminEntity,
    ]),
  ],
  providers: [],
  exports: [],
})
export class AppModelModule {
}
