module.exports = function(grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			options: {
				livereload: true,
			},
			sass: {
				files: [
					'assets/stylesheets/**/*.{scss,sass}',
					'assets/stylesheets/bootstrap/**/*.{scss,sass}',
					'assets/stylesheets/pogradeci/**/*.{scss,sass}'
				],
				tasks: ['sass:dist']
			},
			livereload: {
				//files: ['*.html', '*.php', 'js/**/*.{js,json}', 'css/*.css','img/**/*.{png,jpg,jpeg,gif,webp,svg}'],
				files: ['css/**/*', 'js/**/*', 'images/**', 'templates/**/*', '*.php'],
				options: {
					livereload: true
				}
			}
		},
		sass: {
			options: {
				//sourceMap: true,
				//outputStyle: 'compressed'
			},
			dist: {
				files: {
					'css/bootstrap.css': 'assets/stylesheets/bootstrap.scss',
					'css/font-awesome.css': 'assets/stylesheets/font-awesome.scss',
					'css/pogradeci.css': 'assets/stylesheets/pogradeci.scss'
				}
			}
		}
	});
	grunt.registerTask('default', ['sass:dist', 'watch']);
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
};