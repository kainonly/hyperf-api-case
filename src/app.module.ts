import { Module } from '@nestjs/common';
import { DbModule } from './database/db.module';
import { DbService } from './facade/db.service';
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
