import { log } from './modules/logger';

const main = async () => {
  setTimeout(() => {
    log('Hello, post!');
  }, 1000);
};

main();
