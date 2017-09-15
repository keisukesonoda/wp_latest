'use strict';

const CONFIG = require('./config');
const webpack = require('webpack');

const webpackConf = {

  // エントリーポイント
  entry: {
    main: [`${CONFIG.PATH.src.js}/main.js`],
  },

  // 出力先
  output: {
    filename: '[name].js',
  },

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
