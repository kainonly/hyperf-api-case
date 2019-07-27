import { Module } from '@nestjs/common';
import { DbModule } from './db.module';
import { DbService } from './common/db.service';
import { Main } from './api/main';

@Module({
  controllers: [
    Main,
  ],
  imports: [
    DbModule,
  ],
  providers: [
    DbService,
  ],
})
export class AppModule {
}
