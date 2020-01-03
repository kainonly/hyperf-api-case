import * as path from 'path';
import * as webpack from 'webpack';
import * as nodeExternals from 'webpack-node-externals';
import * as NodemonPlugin from 'nodemon-webpack-plugin';
import { TsconfigPathsPlugin } from 'tsconfig-paths-webpack-plugin';

const config: webpack.Configuration = {
  entry: './src/main.ts',
  target: 'node',
  node: {
    __dirname: false,
    __filename: false,
  },
  mode: 'development',
  module: {
    rules: [
      {
        test: /\.tsx?$/,
        use: 'ts-loader',
        exclude: /node_modules/,
      },
    ],
  },
  externals: [
    nodeExternals(),
  ],
  plugins: [
    new NodemonPlugin(),
  ],
  resolve: {
    extensions: ['.tsx', '.ts', '.js'],
    plugins: [new TsconfigPathsPlugin()],
  },
  output: {
    filename: 'main.js',
    path: path.resolve(__dirname, 'dist'),
  },
};

export default config;
