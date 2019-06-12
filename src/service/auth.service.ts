import { JwtService } from '@nestjs/jwt';
import { Injectable } from '@nestjs/common';
import { Payload } from '../common/payload';

@Injectable()
export class AuthService {
  constructor(
    private readonly jwtService: JwtService,
  ) {
  }

  async signIn(): Promise<string> {
    const payload: Payload = {
      userId: 1,
      roleId: 1,
      symbol: [],
    };
    return this.jwtService.sign(payload);
  }
}
