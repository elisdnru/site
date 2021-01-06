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
    main: './assets/css/main.css',
    admin: './assets/css/admin.css',
    'admin-bar': './assets/css/admin-bar.css',
    comments: './assets/css/comments.css',
    portfolio: './assets/css/portfolio.css',
    colorbox: './assets/css/colorbox.css',
    highlight: './assets/css/highlight.css'
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
        'main.js': [
          'assets/js/site.js',
          'assets/js/form-action.js',
          'assets/js/share.js',
          'assets/js/ulogin.js'
        ],
        'comments.js': [
          'assets/js/comments.js'
        ],
        'jquery.js': [
          'assets/js/jquery.js'
        ],
        'jcarousellite.js': [
          'assets/js/jquery.jcarousellite.js'
        ],
        'colorbox.js': [
          'assets/js/jquery.colorbox.js',
          'assets/js/colorbox.js'
        ],
        'countdown.js': [
          'assets/js/countdown.js'
        ],
      },
      transform: {
        'main.js': code => minify(code).code,
        'jquery.js': code => minify(code).code,
        'comments.js': code => minify(code).code,
        'jcarousellite.js': code => minify(code).code,
        'colorbox.js': code => minify(code).code,
        'countdown.js': code => minify(code).code
      }
    })
  ],
  optimization: {
    minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
  }
}
