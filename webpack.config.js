const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const TerserJSPlugin = require('terser-webpack-plugin')
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')

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
    jquery: './assets/js/jquery.js',
    'jquery-ui': './assets/js/jquery-ui.js',
    countdown: './assets/js/countdown.js'
  },
  output: {
    path: __dirname + '/public/build',
    filename: '[name].js'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      },
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
  ],
  optimization: {
    minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
  }
}
