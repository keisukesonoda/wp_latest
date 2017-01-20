'use strict';

const CONFIG = require('./config');
const webpack = require('webpack');

const webpackConf = {

  // エントリーポイント
  entry: {
    init: [`${CONFIG.PATH.src.js}/init.js`],
    main: [`${CONFIG.PATH.src.js}/main.js`],
  },

  // 出力先
  output: {
    // filename: 'bundle.js',
    filename: '[name].js',
  },

  // ソースマップ出力（https://webpack.github.io/docs/configuration.html#devtool）
  devtool: 'source-map',

  // プラグイン設定（https://github.com/webpack/docs/wiki/list-of-plugins）
  plugins: [
    // ファイル圧縮
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false,
      },
    }),
    // ファイルを細かく分析してまとめられるところは可能な限りまとめて圧縮
    new webpack.optimize.AggressiveMergingPlugin(),
  ],

  // require時の拡張子省略
  resolve: {
    extensions: ['', '.webpack.js', '.web.js', '.js', '.yaml'],
  },

  // javascript意外のソースを読み込むためのモジュール設定
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: 'babel',
        query: {
          presets: ['es2015'],
        },
      },
      {
        test: /\.json$/,
        loader: 'json',
      },
      {
        test: /\.yaml$/,
        loaders: ['json', 'yaml'],
      },
    ],
  },
};

module.exports = webpackConf;
