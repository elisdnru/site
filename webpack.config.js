const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const TerserJSPlugin = require('terser-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const MergeIntoSingleFilePlugin = require('webpack-merge-and-include-globally');

module.exports = {
  mode: 'production',
  context: __dirname,
  entry: {
    main: './assets/css/main.css',
    iframe: './assets/css/iframe.css'
  },
  output: {
    path: __dirname + '/public/build',
    filename: '[name].js'
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader'
        ],
      }
    ]
  },
  plugins: [
    new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      filename: '[name].css',
      chunkFilename: '[id].css',
    }),
    new MergeIntoSingleFilePlugin({
      files: {
        "site.js": [
          'assets/js/jquery.plugins.js',
          'assets/js/follow.js',
          'assets/js/justclick.js',
          'assets/js/justclick.js',
          'assets/js/site.js'
        ],
        "vendor.js": [
          'assets/js/jquery.min.js'
        ]
      },
      transform: {
        'site.js': code => require("uglify-js").minify(code).code,
      }
    })
  ],
  optimization: {
    minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
  }
}
