import { defineConfig, RolldownOptions } from "rolldown";

export default defineConfig(() => {
  const mode = process.env.MODE || "development";
  console.log("Build mode:", mode);

  return [
    createConfig("src/scripts/home.ts", mode),
    createConfig("src/scripts/post.ts", mode),
  ];
});

function createConfig(input: string, mode: string): RolldownOptions {
  return {
    input,
    output: {
      minify: true,
      format: "iife",
      dir: "wordpress/wp-content/themes/custom-theme/assets",
      entryFileNames: "[name].js",
      chunkFileNames: "chunks/[name]-[hash].js",
      assetFileNames: "[name].[ext]",
      sourcemap: mode === "development",
    },
    resolve: {
      extensions: [".ts", ".js"],
    },
    platform: "browser",
    treeshake: true,
    define: {
      "import.meta.env.MODE": JSON.stringify(mode),
      "import.meta.env.PROD": JSON.stringify(mode === "production"),
      "import.meta.env.DEV": JSON.stringify(mode === "development"),
    },
  };
}
