import { PipeTransform, Injectable, ArgumentMetadata, BadRequestException } from '@nestjs/common';
import * as AjvClass from 'ajv';
import { Ajv } from 'ajv';

@Injectable()
export class ValidatePipe implements PipeTransform {
  private ajv: Ajv;

  constructor(
    private readonly schema: any,
  ) {
    this.ajv = new AjvClass();
  }

  transform(value: any, metadata: ArgumentMetadata) {
    console.log(value);
    const valid = this.ajv.validate(this.schema, value);
    if (!valid) {
      throw new BadRequestException({
        error: 1,
        msg: this.ajv.errors,
      });
    }
    return value;
  }
}
