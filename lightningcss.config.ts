import { bundle } from 'lightningcss';
import { writeFileSync, mkdirSync } from 'fs';
import { dirname } from 'path';

const mode = process.env.MODE || 'development';
console.log('Build mode:', mode);

const entries = [
  {
    input: 'src/styles/home.css',
    output: 'wordpress/wp-content/themes/custom-theme/assets/home.css',
  },
  {
    input: 'src/styles/post.css',
    output: 'wordpress/wp-content/themes/custom-theme/assets/post.css',
  },
];

entries.forEach(({ input, output }) => {
  console.log(`\nBuilding ${input}:`);

  const result = bundle({
    filename: input,
    minify: true,
    sourceMap: mode === 'development',
  });

  mkdirSync(dirname(output), { recursive: true });
  writeFileSync(output, result.code);

  if (result.map) {
    writeFileSync(`${output}.map`, result.map);
  }

  console.log(`✓ ${output} (${(result.code.length / 1024).toFixed(2)} KB)`);
  if (result.map) {
    console.log(`✓ ${output}.map (${(result.map.length / 1024).toFixed(2)} KB)`);
  }
});

console.log('CSS build complete!');
