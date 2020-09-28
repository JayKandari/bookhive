//function defaultTask(cb) {
 // place code for your default task here
 //cb()
//}
//exports.default = defaultTask
var gulp = require('gulp');
var sass = require('gulp-sass');
gulp.task('hello', function() {
	console.log('Hello world!')
});

//'use strict';
sass.compiler = require('node-sass');
gulp.task('sass', function () {
  return gulp.src('./public-html/asset/scss/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./public-html/asset/css'));
});
 
gulp.task('watch', function () {
  gulp.watch('./public-html/asset/scss/**/*.scss', ['sass']);
});


//const gulp = require("gulp")
//const sass = require("gulp-sass")
//const watchSass = require("gulp-watch-sass") 
//gulp.task("sass:watch", () => watchSass([
  //"./public-html/asset/**/*.{scss,css}",
  //"!./public/libs/**/*"
//])
  //.pipe(sass())
  //.pipe(gulp.dest("./public")));
