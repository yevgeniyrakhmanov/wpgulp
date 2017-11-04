var gulp           = require('gulp'),
		gutil          = require('gulp-util' ),
		sass           = require('gulp-sass'),
		browserSync    = require('browser-sync'),
		concat         = require('gulp-concat'),
		uglify         = require('gulp-uglify'),
		cleanCSS       = require('gulp-clean-css'),
		rename         = require('gulp-rename'),
		del            = require('del'),
		imagemin       = require('gulp-imagemin'),
		cache          = require('gulp-cache'),
		autoprefixer   = require('gulp-autoprefixer'),
		ftp            = require('vinyl-ftp'),
		notify         = require("gulp-notify"),
		rsync          = require('gulp-rsync');

// Пользовательские скрипты проекта

gulp.task('common-js', function() {
	return gulp.src([
		'wp-content/themes/app/js/common.js',
		])
	.pipe(concat('common.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('wp-content/themes/app/js'));
});

gulp.task('js', ['common-js'], function() {
	return gulp.src([
		'wp-content/themes/app/libs/jquery/dist/jquery.min.js',
		'wp-content/themes/app/libs/popper/popper.min.js',
		// 'wp-content/themes/app/libs/bootstrap/bootstrap.min.js',
		'wp-content/themes/app/libs/bootstrap/util.js',
		'wp-content/themes/app/libs/bootstrap/alert.js',
		'wp-content/themes/app/libs/bootstrap/button.js',
		'wp-content/themes/app/libs/bootstrap/carousel.js',
		'wp-content/themes/app/libs/bootstrap/collapse.js',
		'wp-content/themes/app/libs/bootstrap/dropdown.js',
		'wp-content/themes/app/libs/bootstrap/modal.js',
		'wp-content/themes/app/libs/bootstrap/popover.js',
		'wp-content/themes/app/libs/bootstrap/scrollspy.js',
		'wp-content/themes/app/libs/bootstrap/tab.js',
		'wp-content/themes/app/libs/bootstrap/tooltip.js',
		'wp-content/themes/app/js/common.min.js', // Всегда в конце
		])
	.pipe(concat('scripts.min.js'))
	// .pipe(uglify()) Минимизировать весь js (на выбор)
	.pipe(gulp.dest('wp-content/themes/app/js'))
	.pipe(browserSync.reload({stream: true}));
});

gulp.task('browser-sync', function() {
	browserSync({
		proxy: 'wpgulp',
		notify: false,
	});
});

gulp.task('sass', function() {
	return gulp.src([
		'app/sass/**/*.scss',
		'app/sass/**/*.sass'
		])
	.pipe(sass({outputStyle: 'expand'}).on("error", notify.onError()))
	.pipe(rename({suffix: '.min', prefix : ''}))
	.pipe(autoprefixer(['last 15 versions']))
	// .pipe(cleanCSS()) Опционально, закомментировать при отладке
	.pipe(gulp.dest('wp-content/themes/app/css'))
	.pipe(browserSync.reload({stream: true}));
});

gulp.task('watch', ['sass', 'js', 'browser-sync'], function() {
	gulp.watch(['wp-content/themes/app/scss/**/*.scss', 'wp-content/themes/app/sass/**/*.sass'], ['sass']);
	gulp.watch(['wp-content/themes/app/libs/**/*.js', 'wp-content/themes/app/js/common.js'], ['js']);
	gulp.watch('wp-content/themes/app/*.php', browserSync.reload);
	gulp.watch('./*.php', browserSync.reload);
});

gulp.task('imagemin', function() {
	return gulp.src('wp-content/themes/app/img/**/*')
	.pipe(cache(imagemin()))
	.pipe(gulp.dest('wp-content/themes/dist/img')); 
});

gulp.task('build', ['removedist', 'imagemin', 'sass', 'js'], function() {

	var buildFiles = gulp.src([
		'wp-content/themes/app/*.php',
		'wp-content/themes/app/.htaccess',
		]).pipe(gulp.dest('wp-content/themes/dist'));

	var buildCss = gulp.src([
		'wp-content/themes/app/css/main.min.css',
		]).pipe(gulp.dest('wp-content/themes/dist/css'));

	var buildJs = gulp.src([
		'wp-content/themes/app/js/scripts.min.js',
		]).pipe(gulp.dest('wp-content/themes/dist/js'));

	var buildFonts = gulp.src([
		'wp-content/themes/app/fonts/**/*',
		]).pipe(gulp.dest('wp-content/themes/dist/fonts'));

});

gulp.task('deploy', function() {

	var conn = ftp.create({
		host:      'hostname.com',
		user:      'username',
		password:  'userpassword',
		parallel:  10,
		log: gutil.log
	});

	var globs = [
	'wp-content/themes/dist/**',
	'wp-content/themes/dist/.htaccess',
	];
	return gulp.src(globs, {buffer: false})
	.pipe(conn.dest('/path/to/folder/on/server'));

});

gulp.task('rsync', function() {
	return gulp.src('wp-content/themes/dist/**')
	.pipe(rsync({
		root: 'wp-content/themes/dist/',
		hostname: 'username@yousite.com',
		destination: 'yousite/public_html/',
		archive: true,
		silent: false,
		compress: true
	}));
});

gulp.task('removedist', function() { return del.sync('wp-content/themes/dist'); });
gulp.task('clearcache', function () { return cache.clearAll(); });

gulp.task('default', ['watch']);
