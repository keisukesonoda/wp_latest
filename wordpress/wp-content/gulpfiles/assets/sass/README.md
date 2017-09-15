# sass

## sass-template

・package-json

``` json
{
  "name": "sass-template",
  "version": "1.0.0",
  "description": "",
  "main": "index.js",
  "scripts": {
    "test": "echo \"Error: no test specified\" && exit 1"
  },
  "author": "",
  "license": "ISC",
  "dependencies": {
    "browser-sync": "^2.18.7",
    "gulp": "^3.9.1",
    "gulp-autoprefixer": "^3.1.1",
    "gulp-plumber": "^1.1.0",
    "gulp-sass": "^3.1.0"
  }
}
```



・gulpfile.js

``` javascript
const gulp = require('gulp');
const browser = require('browser-sync');

const sass = require('gulp-sass');
const plumber = require('gulp-plumber');
const autoprefixer = require('gulp-autoprefixer');

gulp.task('server', () => {
  browser({
    server: {
      baseDir: './app/',
    },
    port: 8000,
    notify: false,
    open: false,
  });
});


const sassFiles = [];
const compileFiles = [
  'style',
  'style.sp',
  'editor-style',
];
gulp.task('sass', () => {
  compileFiles.map((val) => {
    const file = `./sass/${val}.scss`;
    return sassFiles.push(file);
  });

  gulp.src(sassFiles)
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
      .pipe(gulp.dest(`./app/css`))
      .pipe(browser.reload({ stream: true }));
});

gulp.task('watch', () => {
  gulp.watch('./sass/**', ['sass']);
});


gulp.task('default', ['server', 'watch']);
```


・app/index.html
``` html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./css/style.sp.css" media="screen and (max-width: 767px)">
  <link rel="stylesheet" href="./css/style.css" media="screen and (min-width: 768px)">
  <title>sass template</title>
</head>
<body>
  <h1>sass template</h1>
</body>
</html>
```


