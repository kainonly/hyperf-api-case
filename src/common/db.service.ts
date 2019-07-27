import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Router } from '../database/router';
import { Api } from '../database/api';
import { ApiType } from '../database/api-type';
import { Role } from '../database/role';
import { RoleRelations } from '../database/role-relations';
import { Admin } from '../database/admin';

@Injectable()
export class DbService {
  constructor(
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
