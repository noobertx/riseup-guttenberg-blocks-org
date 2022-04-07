const { src, dest, series } = require('gulp');
const zip = require('gulp-zip');
const replace = require('gulp-replace');
const clean = require('gulp-clean');
const minifyCSS = require('gulp-csso');
const minifyJS = require('gulp-minify');
const concatCss = require('gulp-concat-css');
const merge = require('merge-stream');

function cleanBuild() {
    return src('../riseupblocks-prod', {read: false, allowEmpty: true})
        .pipe(clean({force: true}));
}

function cleanZip() {
    return src('./wprig.zip', {read: false, allowEmpty: true})
        .pipe(clean());
}

function makeBuild() {
    return src([
        './**/*.*',
        '!./src/**/*.*',
        '!./assets/reactjs/**/*.*',
        '!./assets/js/wprig.dev.js.map',
        '!./assets/js/wprig.dev.js',
        './assets/css/animation.css',
        './assets/css/magnific-popup.css',
        './assets/css/wprig.animatedheadline.css',
        './assets/css/style.min.css',
        './dist/*.*',
        '!./node_modules/**/*.*',
        '!./docs/**/*.*',
        '!./**/*.zip',
        '!./gulpfile.js',
        '!./babel.config.js',
        '!./recompile.js',
        '!./recompileOnChange.js',
        '!./webpack.config.js',
        '!./readme.md',
        '!./LICENSE.txt',
        '!./package.json',
        '!./package-lock.json',
    ]).pipe(dest('../riseupblocks-prod/'));
}

function productionMode() {
    const replacement_string = '\n\t\t\twp_enqueue_style(\'wprig-bundle\', WPRIG_DIR_URL . \'assets/css/wprig.bundle.min.css\', false, microtime());\n\t\t\t';
    return src(['./rise-up.class.php'])
        .pipe(replace(/(?<=#START_REPLACE)([^]*?)(?=#END_REPLACE)/g, replacement_string))
        .pipe(replace(/wprig\.dev\.js/g, 'wprig.min.js'))
        .pipe(replace(/jquery\.animatedheadline\.js/g, 'jquery.animatedheadline.min.js'))
        .pipe(replace(/map\.js/g, 'map.min.js'))
        .pipe(replace(/wprig\.magnific-popup\.js/g, 'wprig.magnific-popup.min.js'))
        .pipe(replace(/contactform\.js/g, 'contactform.min.js'))
        .pipe(replace(/interaction\.js/g, 'interaction.min.js'))
        .pipe(replace(/common-script\.js/g, 'common-script.min.js'))
        .pipe(dest('../riseupblocks-prod/'));
}

function gulpConcatCss() {
    return src([
        './assets/css/animation.css',
        './assets/css/magnific-popup.css',
        './assets/css/wprig.animatedheadline.css'
    ])
        .pipe(concatCss('wprig.bundle.min.css'))
        .pipe(dest('../riseupblocks-prod/assets/css/'))
}

function minify_css() {
    return src(['../riseupblocks-prod/assets/css/*.css'])
        .pipe(minifyCSS())
        .pipe(dest('../riseupblocks-prod/assets/css/'));
}

function minify_js() {
    const commonjs =  src(['../riseupblocks-prod/assets/js/*.js'])
        .pipe(minifyJS({
            ext:{
                src:'.js',
                min:'.min.js'
            },
            exclude: ['tasks'],
            ignoreFiles: ['wprig.min.js', '*-min.js', '*.min.js']
        }))
        .pipe(dest(['../riseupblocks-prod/assets/js/']));

    const blocksjs = src(['../riseupblocks-prod/assets/js/blocks/*.js'])
        .pipe(minifyJS({
            ext:{
                src:'.js',
                min:'.min.js'
            },
            exclude: ['tasks'],
            ignoreFiles: ['wprig.min.js', '*-min.js', '*.min.js']
        }))
        .pipe(dest(['../riseupblocks-prod/assets/js/blocks/']));

    return merge(commonjs, blocksjs);
}

function removeJsFiles() {
    return src(['../riseupblocks-prod/assets/js/common-script.js'], {read: false, allowEmpty: true})
        .pipe(clean());
}

function makeZip() {
    return src('riseupblocks-prod/**/*.*')
        .pipe(zip('wprig.zip'))
        .pipe(dest('./'))
}

exports.makeBuild = makeBuild;
exports.productionMode = productionMode;
exports.gulpConcatCss = gulpConcatCss;
exports.minify_css = minify_css;
exports.minify_js = minify_js;
exports.cleanBuild = cleanBuild;
exports.cleanZip = cleanZip;
exports.removeJsFiles = removeJsFiles;
exports.makeZip = makeZip;


exports.default = series(cleanBuild, cleanZip, makeBuild, productionMode,gulpConcatCss, minify_css, minify_js);

//exports.default = series(cleanBuild, cleanZip, makeBuild, productionMode,gulpConcatCss, minify_css, minify_js, removeJsFiles, makeZip, cleanBuild);