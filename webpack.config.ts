import * as path from 'path';
import * as webpack from 'webpack';
import * as nodeExternals from 'webpack-node-externals';

const compiler = webpack({
  entry: './src/main.ts',
  target: 'async-node',
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
  resolve: {
    extensions: ['.tsx', '.ts', '.js'],
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'dist'),
  },
});

compiler.watch({
  ignored: [
    'node_modules',
    'dist',
  ],
}, (err, stats) => {
  if (err) {
    console.log(err.message);
    return;
  }
  console.log('ok');
});
export default compiler.options;
