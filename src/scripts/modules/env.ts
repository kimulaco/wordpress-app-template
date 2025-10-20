const PROD_MODE = 'production';

export const isProdMode = (): boolean => {
  return import.meta.env.MODE === PROD_MODE;
};
