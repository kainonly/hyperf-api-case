import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { Api } from './entity/api';
import { ApiType } from './entity/api-type';
import { Router } from './entity/router';
import { Role } from './entity/role';
import { RoleRelations } from './entity/role-relations';
import { Admin } from './entity/admin';

@Module({
  imports: [
    TypeOrmModule.forRoot({
      cli: {
        migrationsDir: 'src/database/migration',
      },
    }),
    TypeOrmModule.forFeature([
      Api,
      ApiType,
      Router,
      Role,
      RoleRelations,
      Admin,
    ]),
  ],
  exports: [TypeOrmModule],
})
export class DbModule {
}
