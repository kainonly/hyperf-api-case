import { NestFactory } from '@nestjs/core';
import {
  FastifyAdapter,
  NestFastifyApplication,
} from '@nestjs/platform-fastify';

import { AppModule } from './app.module';

NestFactory.create<NestFastifyApplication>(
  AppModule,
  new FastifyAdapter(),
).then(async (app) => {
  await app.listen(3000, '0.0.0.0');
});
