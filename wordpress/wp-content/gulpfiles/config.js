'use strict';

const gulp = require('gulp');
const GLOB = require('./gulpfile');

/**
 * directory names
 */
const CONFIG = {};
CONFIG.THEME = {
  master: 'mybasic',
};

CONFIG.DIR = {
  context: GLOB.context,
  src: 'assets',
  dest: 'themes',
  theme: CONFIG.THEME.master,
  es6: 'es6',
  sass: 'sass',
  img: 'images',
  css: 'css',
  js: 'js',
};

/**
 * path settings
 */
const dir = CONFIG.DIR;
const path  = {
  src: `${dir.context}/${dir.src}`,
  dest: `../${dir.dest}/${dir.theme}`,
}
CONFIG.PATH = {
  src: {
    sass: `${path.src}/${dir.sass}`,
    css: `${path.src}/${dir.css}`,
    js: `${path.src}/${dir.es6}`,
    img: `${path.src}/${dir.img}`,
  },
  dest: {
    root: `${path.dest}`,
    css: `${path.dest}`,
    js: `${path.dest}/${dir.js}`,
    img: `${path.dest}/${dir.img}`,
  },
  other: {
    plugins: 'plugins',
  },
};

module.exports = CONFIG;


/**
 * start gulp
 */
gulp.task('default', ['server', 'watch']);
