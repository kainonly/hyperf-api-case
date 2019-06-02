import { Controller, Get } from '@nestjs/common';

@Controller('main')
export class MainController {
  @Get()
  index(): any {
    return [];
  }
}
