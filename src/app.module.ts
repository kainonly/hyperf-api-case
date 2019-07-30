import { Module } from '@nestjs/common';
import { join } from 'path';
import { DbModule } from './database/db.module';

import { Main } from './api/main';

import { DbService } from './common/db.service';
import { FacadeService } from './common/facade.service';
import { AdminCache } from './cache/admin.cache';

@Module({
  imports: [
    DbModule,
  ],
  controllers: [
    Main,
  ],
  providers: [
    DbService,
    FacadeService,
    AdminCache,
  ],
})
export class AppModule {
}
