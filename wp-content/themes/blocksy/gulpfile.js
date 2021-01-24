const gulp = require('gulp')
const buildProcess = require('ct-build-process')
const removeCode = require('gulp-remove-code')
const shell = require('gulp-shell')
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer')
	.BundleAnalyzerPlugin

const data = require('./package.json')

const wpExternals = {
	'@wordpress/element': 'window.wp.element',
	'@wordpress/hooks': 'window.wp.hooks',
	'@wordpress/components': 'window.wp.components',
	'@wordpress/date': 'window.wp.date',
	'@wordpress/edit-post': 'window.wp.editPost',
	'@wordpress/plugins': 'window.wp.plugins',
	'@wordpress/data': 'window.wp.data',
	'@wordpress/compose': 'window.wp.compose',
	'@wordpress/api-fetch': 'window.wp.apiFetch',
	'blocksy-options': 'window.blocksyOptions',
	react: 'React',
	'react-dom': 'ReactDOM',
}

var options = {
	packageType: 'wordpress_theme',
	packageSlug: 'blocksy',
	packageI18nSlug: 'blocksy',

	browserSyncInitOptions: {
		logSnippet: false,
		port: 9669,
		domain: 'localhost',
		ui: {
			port: 9068,
		},
	},

	entries: [
		{
			entry: './static/js/events.js',
			output: {
				filename: 'events.js',
				path: './static/bundle/',
				chunkFilename: '[id].[chunkhash].js',

				library: 'ctEvents',
			},
		},

		{
			entry: './static/js/main.js',
			output: {
				library: 'ctFrontend',
				libraryTarget: 'global',

				jsonpFunction: 'blocksyJsonP',
				path: './static/bundle/',
				chunkFilename: '[id].[chunkhash].js',
			},

			optimization: {
				splitChunks: {
					cacheGroups: {
						default: false,
						vendors: false,

						popper: {
							chunks: 'all',
							test: /popper/,
						},
					},
				},
			},
		},

		{
			entry: './static/js/options.js',
			output: {
				filename: 'options.js',
				path: './static/bundle/',
				chunkFilename: '[id].[chunkhash].js',
				jsonpFunction: 'blocksyJsonP',
				library: 'blocksyOptions',
			},

			externals: {
				_: 'window._',
				jquery: 'jQuery',
				'ct-i18n': 'window.wp.i18n',
				'ct-events': 'ctEvents',
				underscore: 'window._',
				...wpExternals,
			},
		},

		{
			entry: './static/js/customizer/sync.js',
			output: {
				filename: 'sync.js',
				path: './static/bundle/',
				jsonpFunction: 'blocksyJsonP',
				library: 'blocksyCustomizerSync',
			},
			externals: {
				_: 'window._',
				jquery: 'jQuery',
				'ct-i18n': 'window.wp.i18n',
				'ct-events': 'ctEvents',
				underscore: 'window._',
				...wpExternals,
			},
		},

		{
			entry: './static/js/editor.js',
			output: {
				filename: 'editor.js',
				path: './static/bundle/',
				jsonpFunction: 'blocksyEditorJsonP',
			},
			externals: {
				_: 'window._',
				jquery: 'jQuery',
				'ct-i18n': 'window.wp.i18n',
				'ct-events': 'ctEvents',
				underscore: 'window._',
				...wpExternals,
			},
		},

		{
			entry: './static/js/customizer/controls.js',
			output: {
				filename: 'customizer-controls.js',
				path: './static/bundle/',
				jsonpFunction: 'blocksyJsonP',
				chunkFilename: '[id].[chunkhash].js',
				library: 'blocksyOptions',
			},
			externals: {
				_: 'window._',
				jquery: 'jQuery',
				'ct-i18n': 'window.wp.i18n',
				'ct-events': 'ctEvents',
				underscore: 'window._',
				...wpExternals,
			},
		},

		{
			entry: './admin/dashboard/static/js/main.js',
			output: {
				path: './admin/dashboard/static/bundle',
				jsonpFunction: 'blocksyJsonP',
			},
			externals: {
				jquery: 'jQuery',
				'ct-i18n': 'window.wp.i18n',
				'ct-events': 'ctEvents',
				underscore: 'window._',
				...wpExternals,
			},
		},
	],

	sassFiles: [
		{
			input: 'static/sass/frontend/main.scss',
			output: 'static/bundle',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'static/sass/frontend/3-actions/no-scripts.scss',
			output: 'static/bundle',
			filename: 'no-scripts',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'static/sass/frontend/8-integrations/forminator/main.scss',
			output: 'static/bundle',
			filename: 'forminator',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'static/sass/frontend/8-integrations/woocommerce/main.scss',
			output: 'static/bundle',
			filename: 'woocommerce',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'static/sass/backend/editor/main.scss',
			output: 'static/bundle',
			filename: 'editor',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'static/sass/backend/customizer/main.scss',
			output: 'static/bundle',
			filename: 'customizer-controls',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'static/sass/backend/admin/elementor.scss',
			output: 'static/bundle',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'static/sass/backend/admin.scss',
			output: 'static/bundle',
			filename: 'options',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'admin/dashboard/static/sass/main.scss',
			output: 'admin/dashboard/static/bundle',
			header: buildProcess.headerFor(false, data),
		},

		// rtl
		{
			input: 'static/sass/frontend/main-rtl.scss',
			output: 'static/bundle',
			filename: 'main-rtl',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'static/sass/backend/editor/main-rtl.scss',
			output: 'static/bundle',
			filename: 'editor-rtl',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'static/sass/backend/customizer/main-rtl.scss',
			output: 'static/bundle',
			filename: 'customizer-controls-rtl',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'static/sass/backend/admin-rtl.scss',
			output: 'static/bundle',
			filename: 'options-rtl',
			header: buildProcess.headerFor(false, data),
		},

		{
			input: 'admin/dashboard/static/sass/main-rtl.scss',
			output: 'admin/dashboard/static/bundle',
			filename: 'main-rtl',
			header: buildProcess.headerFor(false, data),
		},
	],

	browserSyncEnabled: true,

	sassWatch: [
		'static/sass/**/*.scss',
		'admin/dashboard/static/sass/**/*.scss',
	],

	webpackExternals: {
		jquery: 'jQuery',
		'ct-i18n': 'window.wp.i18n',
		'ct-events': 'ctEvents',
		underscore: 'window._',
		'@wordpress/element': 'window.wp.element',
		'@wordpress/hooks': 'window.wp.hooks',
		'@wordpress/date': 'window.wp.date',
	},

	commonWebpackFields: {},

	webpackPlugins: [
		/*
		new BundleAnalyzerPlugin({
			analyzerPort: 0
		})
        */
	],

	webpackResolveAliases: {
		'ct-log': 'ct-wp-js-log',
	},

	babelAdditionalPlugins: ['babel-plugin-lodash'],

	modulesToCompileWithBabel: ['@wordpress/element', 'flexy'],

	filesToDeleteFromBuild: [
		'./build_tmp/build/Blocksy.code-workspace',
		'./build_tmp/build/tags',
		'./build_tmp/build/node_modules/',
		'./build_tmp/build/phpcs.xml.dist',
		'./build_tmp/build/child-theme/',
		'./build_tmp/build/composer.json',
		'./build_tmp/build/yarn.lock',
		'./build_tmp/build/wp-cli.yml',
		'./build_tmp/build/docs',
		'./build_tmp/build/extensions.json',
		// './build_tmp/build/gulpfile.js',
		// './build_tmp/build/package.json',
		'./build_tmp/build/psds',
		'./build_tmp/build/ruleset.xml',
		'./build_tmp/build/tests',
		'./build_tmp/build/scripts',
		'./build_tmp/build/inc/browser-sync.php',
		// './build_tmp/build/admin/dashboard/static/{js,sass}',
		// './build_tmp/build/static/{js,sass}'
		],

	toClean: ['static/bundle/', 'admin/dashboard/static/bundle/'],

	babelJsxPlugin: 'react',
	babelJsxReactPragma: 'createElement',
}

buildProcess.registerTasks(gulp, options)

gulp.task(
	'gettext-generate-js',
	shell.task(['NODE_ENV_GETTEXT=true NODE_ENV=production yarn gulp build'], {
		ignoreErrors: true,
		verbose: true,
	})
)

gulp.task(
	'gettext-generate',
	gulp.series(
		'gettext-generate-js',
		'gettext-generate:php',
		shell.task(
			[
				"msgcat $(find -L . -name \"blocksy-php.pot\" | grep -v 'node_modules') $(find -L . -name \"ct-js.pot\" | grep -v 'node_modules') | grep -v '#-#-#-#' > ./languages/blocksy.pot && rm ./languages/blocksy-php.pot ./languages/ct-js.pot",
			],
			{
				ignoreErrors: true,
				verbose: true,
			}
		),

		shell.task(['yarn build'], {
			ignoreErrors: true,
			verbose: true,
		})
	)
)
