import { Injectable } from '@nestjs/common';
import { config, DotenvParseOutput } from 'dotenv';
import * as RedisClient from 'ioredis';
import { Redis } from 'ioredis';

@Injectable()
export class FacadeService {
  redis: Redis;
  env: any | DotenvParseOutput;

  constructor() {
    this.env = config().parsed;
    this.redis = new RedisClient({
      port: this.env.REDIS_PORT,
      host: this.env.REDIS_HOST,
      password: this.env.REDIS_PASSWORD,
      db: this.env.REDIS_DB,
    });
  }
}
