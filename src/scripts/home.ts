import { log } from './modules/logger';

const main = async () => {
  setTimeout(() => {
    log('Hello, home!');
  }, 1000);
};

main();
