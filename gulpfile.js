/* global require */

'use strict';

var gulp        = require('gulp'),
    del         = require('del'),
    gutil       = require('gulp-util'),
    $           = require('gulp-load-plugins')();

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
 * gulp test
 */
gulp.task('test', ['phpunit']);

/**
 * gulp phpunit
 */
gulp.task('phpunit', function () {
  return gulp.src('tests/**/Test*.php')
    .pipe($.phpunit());
});

/**
 * gulp apigen
 */
gulp.task('apigen', function () {
  gulp.src('apigen.neon')
    .pipe($.apigen());
});

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
 * gulp clean
 */
gulp.task('clean', function (cb) {
  return del(['vendor', 'docs/apigen'], cb);
});

/**
 * gulp rebuild
 */
gulp.task('rebuild', ['clean'], function () {
  gulp.start(['build']);
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
