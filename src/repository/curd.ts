import { Repository } from 'typeorm';

export class Curd {
  constructor(
    public repository: Repository<any>,
  ) {
  }
}
