const GLOB = require('../gulpfile');
const CONFIG = require('../config');
const gulp = require('gulp');
const copy = require('gulp-copy');
const imagemin = require('gulp-imagemin');
const pngquant = require('imagemin-pngquant');
const imageminJpegoptim = require('imagemin-jpegoptim');

gulp.task('image:copy', () => {
  gulp.src(`${CONFIG.PATH.src.img}/**`, {
        base: `${CONFIG.PATH.src.img}`,
      })
      .pipe(gulp.dest(`${CONFIG.PATH.dest.img}`));
});

gulp.task('image:min', () => {
  gulp.src(`${CONFIG.PATH.src.img}/**`)
    .pipe(imagemin([
      pngquant({
        quality: '60-80',
        speed: 1,
      }),
      imageminJpegoptim({
        max: 80,
      }),
      imagemin.svgo(),
      imagemin.gifsicle(),
    ]))
    .pipe(imagemin())
    .pipe(gulp.dest(`${CONFIG.PATH.dest.img}`));
});
