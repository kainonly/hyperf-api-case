import * as fastify from 'fastify';

const server: fastify.FastifyInstance = fastify({
  logger: true,
});
server.listen(3000, '127.0.0.1', (err, address) => {
  if (err) {
    server.log.error(err);
    process.exit(1);
  }
  server.log.info(`server listening on ${address}`);
});
