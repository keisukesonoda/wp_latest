'use strict';

const CONFIG = require('../config');
const webpackConfig = require('../webpack.config.js');
const gulp = require('gulp');
const webpack = require('gulp-webpack');
const browser = require('browser-sync');

/**
 * webpack
 */
gulp.task('webpack', () => {
  gulp.src([
    `${CONFIG.PATH.src.js}/*.js`,
  ])
      .pipe(webpack(webpackConfig))
      .pipe(gulp.dest(`${CONFIG.PATH.dest.js}`))
      .pipe(browser.reload({
        stream: true,
      }));
});
