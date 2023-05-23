// Gulp.js configuration
'use strict';

const //Adding constants

  // source and build folders

    //Styles Directories
    styleSRC      = '../assets/scss/style.scss',
    styleBUILD    = './../build/css/',
    styleWatch    = '../assets/scss/**/*.scss',

    //JavaScripts Directories
    jsSRC         = 'main.js',
    jsFolder      = '../assets/js/',
    jsBUILD       = './../build/js/',
    jsWatch       = '../assets/js/**/*.js',
    jsFILES       = [jsSRC],

    //Images Directories
    imgSRC        = '../assets/images/**',
    imgBUILD      = './../build/images/',
    imgWatch      = '../build/images/**',

    //Fonts Directories
    fontSRC       = '../assets/fonts/*.{eot,svg,ttf,woff,woff2}',
    fontBUILD     = './../build/fonts',
    fontWatch     = '../assets/fonts/**',

    // phpWatch   = '**/*.php',
  
    // Gulp and plugins
    gulp          = require('gulp'),
    rename        = require('gulp-rename'),
    sass          = require('gulp-sass'),
    autoprefixer  = require('gulp-autoprefixer'),
    browserify    = require('browserify'),
    babelify      = require('babelify'),
    source        = require('vinyl-source-stream'),
    buffer        = require('vinyl-buffer'),
    uglify        = require('gulp-uglify'),
    imagemin      = require('gulp-imagemin'),
    sourcemaps    = require('gulp-sourcemaps'),
    browserSync   = require('browser-sync').create(),
    reload        = browserSync.reload
;

//Browser Sync
  gulp.task('browser-sync',function(){
    browserSync.init({
      open:true,
      injectChanges: true,
      //Your project location
      proxy: 'http://localhost/cordeiro'
    });
  });

//Style Compile,minify and map
  gulp.task('style',function(){
      gulp.src(styleSRC)
        .pipe( sourcemaps.init() )
        .pipe(sass({
          errorLogToConsole:true,
          outputStyle: 'compressed'
        }))
        .on( 'error',console.error.bind(console))
        .pipe(autoprefixer({
          browsers: ['last 2 versions'],
          cascade: false
        }))
        .pipe(rename({suffix:'.min'}))
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest(styleBUILD) )
        .pipe( browserSync.stream() );

  });

//Javascript Compile,minify and map
  gulp.task('js',function(){
    jsFILES.map(function( entry ){
        return browserify({
          entries: [jsFolder + entry]
        })
        .transform( babelify, {presets: ['env'] } )
        .bundle()
        .pipe( source( entry ) )
        .pipe( rename({ extname: '.min.js' }) )
        .pipe( buffer() )
        .pipe( sourcemaps.init({ loadMaps: true }) )
        .pipe( uglify() )
        .pipe( sourcemaps.write('./') )
        .pipe( gulp.dest( jsBUILD ) )
        .pipe( browserSync.stream() );
    });
  });

//Images Compile and compress
  gulp.task('images',function(){
    return gulp.src(imgSRC)
        .pipe(imagemin([
            imagemin.gifsicle({ interlaced:true }),
            imagemin.jpegtran({ progressive:true }),
            imagemin.optipng({ optimizationLevel: 5 }),
            imagemin.svgo({ plugins: [{ removeViewBox: true }] })
            ]))
        .pipe(gulp.dest(imgBUILD))  
        .pipe( browserSync.stream() );      
  });

//Fonts Compile
  gulp.task('fonts', function(){
    return gulp.src(fontSRC)        
        .pipe(gulp.dest(fontBUILD));
  });

//Watch scss,js,images,fonts and run browser-sync
  gulp.task('watch' , ['default','browser-sync'] , function(){
    gulp.watch( styleWatch, ['style', reload] );
    gulp.watch( jsWatch, ['js' , reload] );
    gulp.watch( imgWatch, ['images' , reload] );
    gulp.watch( fontWatch, ['fonts' , reload] );
    // gulp.watch( phpWatch, reload );
  });

  //Default Gulp. Just Compile without watch.
  gulp.task('default', ['style','js','images','fonts']);
