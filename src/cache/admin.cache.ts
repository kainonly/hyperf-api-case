import { Injectable } from '@nestjs/common';
import { FacadeService } from '../common/facade.service';

@Injectable()
export class AdminCache {
  constructor(
    private readonly facade: FacadeService,
  ) {
  }

  refresh() {
    this.facade.redis.set('foo', 'bar');
  }
}
