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
    admin: './assets/css/admin.css',
    form: './assets/css/form.css',
    comments: './assets/css/comments.css',
    portfolio: './assets/css/portfolio.css',
    tinymce: './assets/css/tinymce.css',
    'blog-post': './assets/css/blog-post.css',
    smart: './assets/css/smart.css'
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
          'node_modules/axios/dist/axios.min.js',
          'assets/js/follow.js',
          'assets/js/site.js'
        ],
        "jquery.js": [
          'assets/js/jquery.min.js'
        ],
        "jcarousellite.js": [
          'assets/js/jcarousellite.min.js'
        ]
      },
      transform: {
        'site.js': code => require("uglify-js").minify(code).code,
        'jquery.js': code => require("uglify-js").minify(code).code,
        'jcarousellite.js': code => require("uglify-js").minify(code).code
      }
    })
  ],
  optimization: {
    minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
  }
}
