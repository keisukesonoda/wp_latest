'use strict';

const gulp = require('gulp');
const GLOB = require('../gulpfile');

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
  data: 'data',
  img: 'img',
  css: 'css',
  js: 'js',
};

/**
 * path settings
 */
const dir = CONFIG.DIR;
CONFIG.PATH = {
  src: {
    sass: `${dir.context}/${dir.src}/${dir.sass}`,
    css: `${dir.context}/${dir.src}/${dir.css}`,
    js: `${dir.context}/${dir.src}/${dir.es6}`,
    data: `${dir.context}/${dir.src}/${dir.data}`,
  },
  dest: {
    root: `${dir.context}/${dir.dest}/${dir.theme}`,
    img: `${dir.context}/${dir.dest}/${dir.theme}/${dir.img}`,
    js: `${dir.context}/${dir.dest}/${dir.theme}/${dir.js}`,
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
