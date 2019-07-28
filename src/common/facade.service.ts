import { Injectable } from '@nestjs/common';
import { config, DotenvParseOutput } from 'dotenv';
import * as RedisClient from 'ioredis';
import { Redis } from 'ioredis';
import * as AMQP from 'amqplib';
import * as Promise from 'bluebird';
import { Connection } from 'amqplib';

@Injectable()
export class FacadeService {
  env: any | DotenvParseOutput;
  redis: Redis;
  rabbitmq: Promise<Connection>;

  constructor() {
    this.env = config().parsed;
    this.setRedis();
    this.setRabbitMQ();
  }

  private setRedis() {
    this.redis = new RedisClient({
      port: this.env.REDIS_PORT,
      host: this.env.REDIS_HOST,
      password: this.env.REDIS_PASSWORD,
      db: this.env.REDIS_DB,
    });
  }

  private setRabbitMQ() {
    this.rabbitmq = AMQP.connect(this.env.RABBITMQ_PROTOCOL + '://' +
      this.env.RABBITMQ_USER + ':' + this.env.RABBITMQ_PASSWORD + '@' +
      this.env.RABBITMQ_HOST + ':' + this.env.RABBITMQ_PORT + '/'
      + (this.env.RABBITMQ_VHOST ? this.env.RABBITMQ_VHOST : ''),
    );
  }
}
