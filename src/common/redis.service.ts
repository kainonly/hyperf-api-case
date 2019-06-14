import { Injectable } from '@nestjs/common';
import { config } from 'dotenv';
import * as Redis from 'ioredis';

const env: any = config().parsed;

@Injectable()
export class RedisService {
  readonly client: Redis.Redis;

  constructor() {
    this.client = new Redis({
      host: env.REDIS_HOST,
      password: env.REDIS_PASSWORD,
      db: env.REDIS_DB,
    });
  }
}
