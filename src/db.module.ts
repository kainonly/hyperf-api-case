import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { Api } from './database/api';
import { ApiType } from './database/api-type';
import { Router } from './database/router';
import { Role } from './database/role';
import { RoleRelations } from './database/role-relations';
import { Admin } from './database/admin';

@Module({
  imports: [
    TypeOrmModule.forRoot(),
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
