import { Controller, Get } from '@nestjs/common';
import { AppService } from '../services/app.service';
import { Observable } from 'rxjs';

@Controller()
export class AppController {
  constructor(private appService: AppService) {
  }

  @Get('hello')
  getHello(): Observable<any> {
    return this.appService.getHello();
  }
}
