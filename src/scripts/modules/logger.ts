import { isProdMode } from './env';

export const log = (value: unknown): void => {
  if (isProdMode()) {
    return;
  }
  console.log(value);
};

export const error = (value: unknown): void => {
  if (isProdMode()) {
    return;
  }
  console.error(value);
};

export const warn = (value: unknown): void => {
  if (isProdMode()) {
    return;
  }
  console.warn(value);
};
