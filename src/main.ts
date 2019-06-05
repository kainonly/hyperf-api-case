import { NestFactory } from '@nestjs/core';
import {
  FastifyAdapter,
  NestFastifyApplication,
} from '@nestjs/platform-fastify';

import * as helmet from 'helmet';
import * as csurf from 'csurf';
import * as compression from 'compression';

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
  // app.use(helmet());
  // app.use(csurf());
  // app.use(compression());
  await app.listen(3000, '0.0.0.0');
});
