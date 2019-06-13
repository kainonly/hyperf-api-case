import { NestFactory } from '@nestjs/core';
import {
  FastifyAdapter,
  NestFastifyApplication,
} from '@nestjs/platform-fastify';
import * as cookie from 'fastify-cookie';

import { AppModule } from './app.module';

NestFactory.create<NestFastifyApplication>(
  AppModule,
  new FastifyAdapter(),
  {
    cors: {
      origin: ['http://localhost:4200'],
      credentials: true,
    },
  },
).then(async (app) => {
  app.register(cookie);
  await app.listen(3000, '0.0.0.0');
});
