import { ValidatePipe } from './common/validate.pipe';

const validate = (schema: any) => new ValidatePipe(schema);

export { validate };
