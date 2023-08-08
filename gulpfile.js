let gulp = require('gulp'),
    sass = require('gulp-sass'),
    header = require('gulp-header'),
    cleanCSS = require('gulp-clean-css'),
    rename = require("gulp-rename"),
    uglify = require('gulp-uglify'),
    watch = require('gulp-watch'),
    sourcemaps = require('gulp-sourcemaps'),
    browserSync = require('browser-sync').create();


gulp.task('image:copy', function () {
    gulp.src('./resources/assets/img/**/*').pipe(
        gulp.dest('./public/img')
    )
});


/*// Minify CSS
gulp.task('css:minify', ['css:compile'], function () {
    return gulp.src([
        './public/css/!**!/!*.css',
        '!./public/css/!**!/!*.min.css'
    ])
        .pipe(cleanCSS())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./public/css'))
        .pipe(browserSync.stream());
});*/

// CSS
// gulp.task('css', ['css:compile', 'css:minify']);
//copy js files

gulp.task('font:copy', function () {
    gulp.src('./resources/assets/fonts/**/*')
        .pipe(gulp.dest('./public/fonts'));

    gulp.src('./resources/assets/font-awesome/**/*')
        .pipe(gulp.dest('./public/font-awesome'));
});

gulp.task('css:copy', function () {
    gulp.src('./resources/assets/css/**/*')
        .pipe(gulp.dest('./public/css'));
});

//copy js files
gulp.task('js:copy', function () {
    gulp.src('./resources/assets/js/**/*.js').pipe(rename({
        // suffix: '.min'
    })).pipe(gulp.dest('./public/js'));
});

// Minify JavaScript
/*gulp.task('js:minify', function () {
    return gulp.src([
        './public/js/!*.js',
        '!./public/js/!*.min.js'
    ])
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./public/js'))
        .pipe(browserSync.stream());
});*/


// JS
// gulp.task('js', ['js:copy', 'js:minify']);
// gulp.task('copy', ['css:copy', 'js:copy']);

// Default task
gulp.task('default', ['font:copy', 'css:copy', 'js:copy', 'image:copy']);


// Configure the browserSync task
gulp.task('browserSync', function () {
    browserSync.init({
        proxy: 'cdis.test',
        notify: false
    });
});

// Dev task
gulp.task('dev', ['css:copy', 'js:copy', 'browserSync'], function () {
    gulp.watch('./resources/assets/css/*.css', ['css:copy'], browserSync.reload());
    gulp.watch('./resources/assets/js/*.js', ['js:copy'], browserSync.reload());
    gulp.watch('./resources/views/**/*.php', browserSync.reload);
});



