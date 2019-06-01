import { Injectable } from '@nestjs/common';
import { ConfigService } from './config.service';
import * as Redis from 'ioredis';

@Injectable()
export class RedisService {
  constructor(
    configService: ConfigService,
  ) {
    Redis({
      host: configService.get('redis_host'),
      password: configService.get('redis_password'),
      db: 0,
    });
  }
}
