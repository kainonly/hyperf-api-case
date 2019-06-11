import { NestFactory } from '@nestjs/core';
import {
  FastifyAdapter,
  NestFastifyApplication,
} from '@nestjs/platform-fastify';

import * as cookieParser from 'cookie-parser';

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
  app.use(cookieParser());
  await app.listen(3000, '0.0.0.0');
});
