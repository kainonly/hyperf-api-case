import { Injectable } from '@nestjs/common';
import { config } from 'dotenv';

@Injectable()
export class ConfigService {
  private storage: Map<string, any> = new Map();
  env: any;

  constructor() {
    this.env = config().parsed;
  }

  set(key: string, value: any) {
    this.storage.set(key, value);
  }

  get(key: string) {
    return this.storage.get(key);
  }
}
