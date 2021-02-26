const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const TerserJSPlugin = require('terser-webpack-plugin')
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const MergeIntoSingleFilePlugin = require('webpack-merge-and-include-globally')
const { minify } = require('uglify-js')

module.exports = {
  mode: 'production',
  context: __dirname,
  entry: {
    main: './assets/js/main.js',
    admin: './assets/css/admin.css',
    'admin-bar': './assets/css/admin-bar.css',
    comments: './assets/js/comments.js',
    portfolio: './assets/css/portfolio.css',
    highlight: './assets/css/highlight.css',
    jquery: './assets/js/jquery.js'
  },
  output: {
    path: __dirname + '/public/build',
    filename: '[name].js'
  },
  module: {
    rules: [
      {
        test: /\.(png|jpg|gif)$/,
        use: ['file-loader']
      },
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
      chunkFilename: '[id].css'
    }),
    new MergeIntoSingleFilePlugin({
      files: {
        'countdown.js': [
          'assets/js/countdown.js'
        ],
      },
      transform: {
        'countdown.js': code => minify(code).code
      }
    })
  ],
  optimization: {
    minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
  }
}
