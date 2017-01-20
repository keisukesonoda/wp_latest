'use strict';

const CONFIG = require('../config');
const gulp = require('gulp');
const browser = require('browser-sync');

/**
 * server
 */
gulp.task('server', () => {
  browser({
    proxy: 'localhost',
    port: 8000,
    notify: false,
    open: false,
  });
});


/**
 * reload
 */
gulp.task('reload', () => {
  gulp.src(`${CONFIG.PATH.dest.root}`)
      .pipe(browser.reload({
        stream: true,
      }));
});
