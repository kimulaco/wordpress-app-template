import { isProdMode } from './env';

export const log = (value: unknown): void => {
  if (isProdMode()) {
    return;
  }
  console.log(value); // oxlint-disable-line no-console
};

export const error = (value: unknown): void => {
  if (isProdMode()) {
    return;
  }
  console.error(value); // oxlint-disable-line no-console
};

export const warn = (value: unknown): void => {
  if (isProdMode()) {
    return;
  }
  console.warn(value); // oxlint-disable-line no-console
};
