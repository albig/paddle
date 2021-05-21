import { src, dest, watch, series, parallel } from 'gulp';
import yargs from 'yargs';
import sass from 'gulp-sass';
import cleanCss from 'gulp-clean-css';
import sourcemaps from 'gulp-sourcemaps';
import gulpif from 'gulp-if';
import imagemin from 'gulp-imagemin';
import browserSync from "browser-sync";
import zip from "gulp-zip";
import info from "./package.json";
import wpPot from "gulp-wp-pot";

const gulp = require('gulp');
const babel = require('gulp-babel');
const uglify = require( 'gulp-uglify' );
const rename = require( 'gulp-rename' );
const rtlcss = require('gulp-rtlcss');
const PRODUCTION = yargs.argv.prod;
const autoprefixer = require( 'gulp-autoprefixer' );
const server = browserSync.create();

/** Style */
export const styles = () => {
    return src('src/scss/theme.scss')
      .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
      .pipe(sass().on('error', sass.logError))
      .pipe(gulpif(PRODUCTION,  autoprefixer( 'last 2 versions' )))
      .pipe(dest('css/'))
      .pipe(gulpif(PRODUCTION, cleanCss({compatibility:'ie8'})))
      .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
      .pipe(gulpif(PRODUCTION,  rename( { suffix: '.min' } ) ))
      .pipe(dest('css/'))
      .pipe(server.stream());
  }

/** WooCommerce Styles */
/** Style */
export const woo_styles = () => {
  return src('src/scss/woocommerce.scss')
    .pipe(gulpif(!PRODUCTION, sourcemaps.init()))
    .pipe(sass().on('error', sass.logError))
    .pipe(gulpif(PRODUCTION,  autoprefixer( 'last 2 versions' )))
    .pipe(dest('css/'))
    .pipe(gulpif(PRODUCTION, cleanCss({compatibility:'ie8'})))
    .pipe(gulpif(!PRODUCTION, sourcemaps.write()))
    .pipe(gulpif(PRODUCTION,  rename( { suffix: '.min' } ) ))
    .pipe(dest('css/'))
    .pipe(server.stream());
}

/** Script */
export const scripts = () => {
    return src([
      'src/js/theme.js',
      'src/js/navigation.js',
      'src/js/logo-script.js'
    ])
    .pipe(dest('js/'))
    .pipe(gulpif(PRODUCTION, 
        babel({
            presets: [
                ["@babel/preset-env"]
            ]
        })
    ))
    .pipe(gulpif(PRODUCTION,  uglify() ))
    .pipe(gulpif(PRODUCTION,  rename( { suffix: '.min' } ) ))
    .pipe(gulpif(PRODUCTION,  dest('js/') ))
}

  // Watch for changes.
  export const watchFor = () => {
    watch('src/scss/**/*.scss', styles);
    watch('src/images/**/*.{jpg,jpeg,png,svg,gif}', series(images, reload));
    watch('src/js/**/*.js', series(scripts, reload) );
    watch("**/*.php", reload);
  }


  // Compress images.
  export const images = () => {
    return src('src/images/**/*.{jpg,jpeg,png,svg,gif}')
      .pipe(gulpif(PRODUCTION, imagemin()))
      .pipe(dest('assets/images'));
  }

   // CSS to RTL.
  export const compilertl = () => {
    return src([
      'css/theme.css',
      'css/woocommerce.css',
      './style.css'
      ])
     .pipe(rtlcss())
     .pipe(rename( { suffix: '-rtl' } ))
     .pipe(gulp.dest('css/'));
  }

  export const serve = done => {
    server.init({
      proxy: "http://localhost/howto/" // put your local website link here
    });
    done();
  };
  export const reload = done => {
    server.reload();
    done();
  };

  // Export the final theme, compressed
  export const compress = () => {
    return src([
        "**/*",
        "!node_modules{,/**}",
        "!bundled{,/**}",
        "!src{,/**}",
        "!vendor{,/**}",
        "!.babelrc",
        "!.gitignore",
        "!gulpfile.babel.js",
        "!package.json",
        "!composer.json",
        "!composer.lock",
        "!package-lock.json",
      ])
      .pipe(zip(`${info.name}.zip`))
      .pipe(dest('bundled'));
};

// For handling pot
export const pot = () => {
    return src("**/*.php")
    .pipe(
        wpPot({
          domain: "paddle",
          package: info.name
        })
      )
    .pipe(dest(`languages/${info.name}.pot`));
  };


export const dev = series(parallel(styles, woo_styles, scripts, images), serve, watchFor)
export const build = series(parallel(styles, woo_styles, scripts, images), pot, compress)
export default dev;