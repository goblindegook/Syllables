/* global require */

'use strict';

var gulp        = require('gulp'),
    del         = require('del'),
    gutil       = require('gulp-util'),
    $           = require('gulp-load-plugins')(),
    browserSync = require('browser-sync'),
    reload      = browserSync.reload;

function _onError (error) {
  gutil.log(gutil.colors.red(error.message));
}

/**
 * gulp composer
 */
gulp.task('composer', function () {
  $.composer({cwd: './', bin: 'composer'});
});

/**
 * gulp install:phpunit
 */
gulp.task('install:phpunit', function () {
  return;
});

/**
 * gulp phpunit
 */
gulp.task('phpunit', function () {
  return gulp.src('tests/**/Test*.php')
    .pipe($.phpunit());
});

/**
 * gulp test
 */
gulp.task('test', ['phpunit']);

/**
 * gulp watch
 */
gulp.task('watch', function () {
  gulp.watch(['src/**/*.php', 'tests/**/*.php'],
    ['test']);

  gulp.watch('composer.json',
    ['composer', 'test']);
});

/**
 * gulp watch:server
 */
gulp.task('watch:server', function () {

  browserSync({
    notify: false,
    server: {
      baseDir: './',
      directory: true,
    },
    host: 'localhost',
    port: 3000,
    logLevel: 'debug'
  });

  /**
   * Rebuild on changed sources.
   */

  gulp.watch(['src/**/*.php', 'tests/**/*.php'],
    ['test', reload]);

  gulp.watch('composer.json',
    ['composer', 'test', reload]);
});

/**
 * gulp clean
 */
gulp.task('clean', function (cb) {
  return del(['vendor'], cb);
});

/**
 * gulp rebuild
 */
gulp.task('rebuild', ['clean'], function () {
  gulp.start(['install:phpunit', 'build']);
});

/**
 * gulp build
 */
gulp.task('build', function () {
  gulp.start('composer');
});

/**
 * gulp
 */
gulp.task('default', function () {
  gulp.start('build');
});
