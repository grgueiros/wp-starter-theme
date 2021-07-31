const gulp = require('gulp'),
  autoprefixer = require('autoprefixer'),
  del = require('del'),
  plumber = require('gulp-plumber'),
  babel = require('gulp-babel'),
  concat = require('gulp-concat'),
  uglify = require('gulp-uglify'),
  rename = require('gulp-rename'),
  sassGlob = require('gulp-sass-glob'),
  sass = require('gulp-sass')(require('sass')),
  postcss = require('gulp-postcss'),
  cssnano = require('cssnano'),
  newer = require('gulp-newer'),
  imagemin = require('gulp-imagemin'),
  browsersync = require('browser-sync'),
  eslint = require('gulp-eslint');


function clean() {
  // return del(['./dist', './assets/css', './assets/scripts', './assets/images'])
  return del(['./dist'])
}

//Javascript
function scripts() {
  return gulp
    .src(['./src/js/vendor/*.js', './src/js/*.js'])
    .pipe(plumber())
    .pipe(
      babel({
        presets: [
          [
            'env',
            {
              loose: true,
              modules: false,
              exclude: ['transform-es2015-typeof-symbol']
            }
          ]
        ],
        plugins: ['@babel/plugin-proposal-object-rest-spread']
      })
    )
    .pipe(concat('main.js'))
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('./dist/js/'))
}

//SCSS
function css() {
  return gulp
    .src('./src/scss/style.scss')
    .pipe(plumber())
    .pipe(sassGlob())
    .pipe(sass({ outputStyle: 'expanded' }))
    .pipe(
      postcss([
        autoprefixer(),
        cssnano({
          discardComments: { removeAll: true }
        }),
      ])
    )
    .pipe(rename({ basename: 'main', suffix: '.min' }))
    .pipe(gulp.dest('./dist/css/'))
}



//Imagens
function optmizeImages() {
  return gulp
    .src('./src/img/**/*')
    .pipe(newer('./dist/images'))
    .pipe(
      imagemin([
        imagemin.gifsicle({ interlaced: true }),
        imagemin.jpegtran({ progressive: true }),
        imagemin.optipng({ optimizationLevel: 5 }),
        imagemin.svgo({
          plugins: [
            {
              removeViewBox: false,
              collapseGroups: true
            }
          ]
        })
      ])
    )
    .pipe(gulp.dest('./dist/images'))
}

function copyImages() {
  return gulp.src('./src/img/**/*').pipe(gulp.dest('./dist/images'))
}

function copyFonts() {
  return gulp.src('./src/fonts/**/*').pipe(gulp.dest('./dist/fonts'));
}

function browserSync(done) {
  browsersync.init({
    proxy: 'axs.local',
    port: 3000,
  })
  done();
}


//Watch
function watchFiles() {
  gulp.watch('./src/scss/**/*', gulp.series(css, browserSyncReload))
  gulp.watch('./src/js/**/*', gulp.series(scripts, browserSyncReload))
  gulp.watch('./src/img/**/*', gulp.series(copyImages, browserSyncReload))
  gulp.watch('./**/*.{html,php}', gulp.series(browserSyncReload))
}

function browserSyncReload(done) {
  browsersync.reload()
  done()
}

const assetsDev = gulp.parallel(scripts, css, copyFonts, copyImages)
const assetsBuild = gulp.parallel(scripts, css, copyFonts, copyImages)
const watch = gulp.parallel(watchFiles, browserSync)

exports.default = gulp.series(clean, assetsBuild)
exports.dev = gulp.series(clean, assetsDev, watch)