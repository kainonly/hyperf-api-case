import { Injectable } from '@nestjs/common';
import * as Redis from 'ioredis';
import { ConfigService } from './config.service';

@Injectable()
export class RedisService {
  readonly client: Redis.Redis;

  constructor(
    configService: ConfigService,
  ) {
    this.client = new Redis({
      host: configService.env.REDIS_HOST,
      password: configService.env.REDIS_PASSWORD,
      db: configService.env.REDIS_DB,
    });
  }
}
