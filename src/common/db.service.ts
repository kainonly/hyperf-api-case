import { Injectable } from '@nestjs/common';
import { InjectConnection, InjectRepository } from '@nestjs/typeorm';
import { Connection, Repository } from 'typeorm';
import { Router } from '../database/entity/router';
import { Api } from '../database/entity/api';
import { ApiType } from '../database/entity/api-type';
import { Role } from '../database/entity/role';
import { RoleRelations } from '../database/entity/role-relations';
import { Admin } from '../database/entity/admin';

@Injectable()
export class DbService {
  constructor(
    @InjectConnection()
    public readonly connection: Connection,
    @InjectRepository(Router)
    public readonly router: Repository<Router>,
    @InjectRepository(Api)
    public readonly api: Repository<Api>,
    @InjectRepository(ApiType)
    public readonly apiType: Repository<ApiType>,
    @InjectRepository(Role)
    public readonly role: Repository<Role>,
    @InjectRepository(RoleRelations)
    public readonly roleRelations: Repository<RoleRelations>,
    @InjectRepository(Admin)
    public readonly admin: Repository<Admin>,
  ) {
  }
}
