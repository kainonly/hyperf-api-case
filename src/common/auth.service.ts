import { JwtService } from '@nestjs/jwt';
import { Injectable } from '@nestjs/common';

@Injectable()
export class AuthService {
  constructor(
    private readonly jwtService: JwtService,
  ) {
  }

  async signIn(): Promise<string> {
    const payload: any = {
      userId: 1,
      roleId: 1,
      symbol: [],
    };
    return this.jwtService.sign(payload);
  }
}
