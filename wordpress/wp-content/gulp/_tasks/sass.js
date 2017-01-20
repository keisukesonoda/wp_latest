'use strict';

const CONFIG = require('../config');
const gulp = require('gulp');
const browser = require('browser-sync');

const sass = require('gulp-sass');
const plumber = require('gulp-plumber');
// const cssmin = require('gulp-cssmin');
// const rename = require('gulp-rename');
// const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');

const sassFiles = [];
const compileFiles = [
  'style',
  'style.sp',
  'editor-style',
];

/**
 * sass
 */
gulp.task('sass', () => {
  compileFiles.map((val) => {
    const file = `${CONFIG.PATH.src.sass}/${val}.scss`;
    return sassFiles.push(file);
  });

  gulp.src(sassFiles)
      // .pipe(sourcemaps.init())
      .pipe(plumber())
      .pipe(sass({
        outputStyle: 'expanded',
      }).on('error', sass.logError))
      .pipe(autoprefixer({
        browsers: [
          'last 2 versions',
          'ie >= 10',
          'Android >= 4.1',
          'ios_saf >= 7',
        ],
        cascade: false,
      }))
      .pipe(gulp.dest(`${CONFIG.PATH.src.css}`))
      // .pipe(cssmin())
      // .pipe(sourcemaps.write('./'))
      // .pipe(rename({ suffix: '.min' }))
      .pipe(gulp.dest(`${CONFIG.PATH.dest.root}`))
      .pipe(browser.reload({ stream: true }));
});
