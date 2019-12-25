import { Application } from '../projects/van-core/src/public-api';

const app = new Application();

app.bootstrap('127.0.0.1', 3000, {
  logger: true,
}).then(address => {
  app.getServer().log.info(`server listening on ${address}`);
}).catch(err => {
  app.getServer().log.error(err);
  process.exit(1);
});
