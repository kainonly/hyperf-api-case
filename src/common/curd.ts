import { Repository } from 'typeorm';

export class Curd {
  constructor(
    public repository: Repository<any>,
  ) {
  }

  add() {
    return {};
  }

  delete() {
    return {};
  }

  edit() {
    return {};
  }

  get() {
    return {};
  }

  lists() {
    return {};
  }

  originLists() {
    return {};
  }
}
