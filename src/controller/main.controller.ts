import { Controller, Get } from '@nestjs/common';
import { UserService } from '../service/user.service';

@Controller('main')
export class MainController {
  constructor(
    private userService: UserService,
  ) {
  }

  @Get()
  index(): any {
    return this.userService.all();
  }
}
