import { Injectable } from '@nestjs/common';
import { config } from 'dotenv';

@Injectable()
export class ConfigService {
  private readonly envConfig: { [key: string]: string };

  constructor() {
    this.envConfig = config().parsed;
  }

  get(key: string): any {
    return this.envConfig[key];
  }
}
