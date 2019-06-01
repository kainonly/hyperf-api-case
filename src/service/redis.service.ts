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
      host: configService.get('redis_host'),
      password: configService.get('redis_password'),
      db: 0,
    });
  }
}
