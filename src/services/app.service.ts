import { Injectable } from '@nestjs/common';
import { Observable, of } from 'rxjs';

@Injectable()
export class AppService {
  getHello(): Observable<any> {
    return of({
      name: 'kain',
    });
  }
}
