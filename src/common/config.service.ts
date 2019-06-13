import { Injectable } from '@nestjs/common';

@Injectable()
export class ConfigService {
  env: { [key: string]: any };
}
