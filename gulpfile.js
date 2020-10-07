
var gulp = require('gulp');
var sass = require('gulp-sass');

// Task to compile main.scss to main.css.
sass.compiler = require('node-sass');
gulp.task('sass', function () {
  return gulp.src('./public-html/asset/scss/**/main.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./public-html/asset/css'));
});
 
// Watch task which inovkes `sass` task whenever there is a change in any `.scss` file.
gulp.task('watch', function () {
  gulp.watch('./public-html/asset/scss/**/*.scss', gulp.series('sass'));
});
