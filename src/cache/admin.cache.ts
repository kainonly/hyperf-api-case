import { Injectable } from '@nestjs/common';
import { RedisService } from '../common/redis.service';

@Injectable()
export class AdminCache {
  constructor(
    private readonly redis: RedisService,
  ) {
  }

  refresh() {
    this.redis.client.set('foo', 'bar');
  }
}
