import { NestFactory } from '@nestjs/core';
import {
  FastifyAdapter,
  NestFastifyApplication,
} from '@nestjs/platform-fastify';
import * as Cors from 'fastify-cors';
import * as Cookie from 'fastify-cookie';
import * as Compress from 'fastify-compress';
import * as Helmet from 'fastify-helmet';

import { AppModule } from './app.module';

NestFactory.create<NestFastifyApplication>(
  AppModule,
  new FastifyAdapter(),
).then(async (app) => {
  app.register(Cors);
  app.register(Cookie);
  app.register(Compress);
  app.register(Helmet);
  await app.listen(3000, '0.0.0.0');
});
