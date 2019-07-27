import { Injectable } from '@nestjs/common';
import { ConfigService } from './config.service';
import * as Redis from 'ioredis';

@Injectable()
export class RedisService {
  client: any;

  constructor(
    config: ConfigService,
  ) {
    this.client = new Redis({
      port: config.env.REDIS_PORT,
      host: config.env.REDIS_HOST,
      password: config.env.REDIS_PASSWORD,
      db: config.env.REDIS_DB,
    });
  }
}
