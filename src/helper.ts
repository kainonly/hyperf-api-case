import { ValidatePipe } from './common/validate.pipe';
import { createParamDecorator } from '@nestjs/common';

const validate = (schema: any) => new ValidatePipe(schema);

const Cookie = createParamDecorator((data, req) => {
  return req.cookies;
});

export { validate, Cookie };
