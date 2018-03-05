var gulp = require("gulp");
var babel = require("gulp-babel");

gulp.task("default", function () {
    return gulp.src("assets/js/app.js")
        .pipe(babel())
        .pipe(gulp.dest("assets/js/es5"));
});