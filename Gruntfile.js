module.exports = function (grunt) {
	grunt.initConfig({
		less: {
			development: {
				options: {
					compress: false,
					yuicompress: true,
					optimization: 2
					},
				files: {
					"options/admin/assets/options.css": "options/admin/assets/options.less",
                    "atf-fields/assets/fields.css": "atf-fields/assets/fields.less"
				}
			}
		},
		watch: {
			styles: {
				files: ['**/assets/**/*.less'], // which files to watch
				tasks: ['less'],
				options: {
					nospawn: true
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['watch']);
};