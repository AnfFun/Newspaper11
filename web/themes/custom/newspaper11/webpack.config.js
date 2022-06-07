const path = require('path');
const miniCss = require('mini-css-extract-plugin');
module.exports = {
  entry: {
    dscss: ['./src/index.js'],
    javascript: ['./src/Drupal.js'],
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'dist')
  },
  module: {
    rules: [{
      test:/\.(s*)css$/,
      use: [
        miniCss.loader,
        'css-loader',
        'sass-loader',
      ]
    }]
  },
  plugins: [
    new miniCss({
      filename: 'style.css',
    }),
  ]
};
