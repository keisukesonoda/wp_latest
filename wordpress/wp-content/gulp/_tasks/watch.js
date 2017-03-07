'use strict';

const CONFIG = require('../config');
const gulp = require('gulp');

/**
 * watch
 */
gulp.task('watch', () => {
  gulp.watch([
    `${CONFIG.PATH.other.plugins}/**`,
    `${CONFIG.PATH.dest.root}/*.php`,
    `${CONFIG.PATH.dest.root}/**/*.php`,
  ], ['reload']);

  gulp.watch([
    `${CONFIG.PATH.src.js}/**`,
  ], ['webpack']);

  gulp.watch([
    `${CONFIG.PATH.src.sass}/**`,
  ], ['sass']);
});
