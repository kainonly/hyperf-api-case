import { Injectable } from '@nestjs/common';
import { ConfigService } from './config.service';
import * as Redis from 'ioredis';

@Injectable()
export class RedisService {
  readonly client: Redis.Redis;

  constructor(
    configService: ConfigService,
  ) {
    this.client = new Redis({
      host: configService.get('REDIS_HOST'),
      password: configService.get('REDIS_PASSWORD'),
      db: configService.get('REDIS_DB'),
    });
  }
}
