// Laravel Mix config.

// Import required packages.
const mix               = require( 'laravel-mix' );
const ImageminPlugin    = require( 'imagemin-webpack-plugin' ).default;
const CopyWebpackPlugin = require( 'copy-webpack-plugin' );
const imageminMozjpeg   = require( 'imagemin-mozjpeg' );

const devPath  = 'resources';

// Public path.
mix.setPublicPath( 'public' );

// Mix options.
mix.options( {
	postCss        : [ require( 'postcss-preset-env' )() ],
	processCssUrls : false
} );

// Source maps.
mix.sourceMaps();

// Cache busting.
mix.version();

// Compile JS.
// mix.js( `${devPath}/js/app.js`, 'js' );

// Sass config.
var sassConfig = {
	outputStyle : 'expanded',
	indentType  : 'tab',
	indentWidth : 1
};

// Compile SASS/CSS.
if ( mix.inProduction() ) {
	mix.sass( `${devPath}/scss/screen.scss`, 'css', sassConfig );
} else {
	mix.standaloneSass( `${devPath}/scss/screen.scss`, 'css', sassConfig );
}

// Add custom Webpack configuration.
mix.webpackConfig( {
	stats       : 'minimal',
	devtool     : mix.inProduction() ? false : 'source-map',
	performance : { hints  : false    },
	externals   : { jquery : 'jQuery' },
	/*
	plugins     : [
		// @link https://github.com/webpack-contrib/copy-webpack-plugin
		new CopyWebpackPlugin( [
			{ from : `${devPath}/img`,   to : 'img'   },
			{ from : `${devPath}/svg`,   to : 'svg'   },
			{ from : `${devPath}/fonts`, to : 'fonts' }
		] ),
		// @link https://github.com/Klathmon/imagemin-webpack-plugin
		new ImageminPlugin( {
			test     : /\.(jpe?g|png|gif|svg)$/i,
			disable  : process.env.NODE_ENV !== 'production',
			optipng  : { optimizationLevel : 3 },
			gifsicle : { optimizationLevel : 3 },
			pngquant : {
				quality : '65-90',
				speed   : 4
			},
			svgo : {
				plugins : [
					{ cleanupIDs                : false },
					{ removeViewBox             : false },
					{ removeUnknownsAndDefaults : false }
				]
			},
			plugins : [
				// @link https://github.com/imagemin/imagemin-mozjpeg
				imageminMozjpeg( { quality : 75 } )
			]
		} )
	]
	*/
} );

if ( process.env.sync ) {

	// BrowserSync config.
	mix.browserSync( {
		proxy : 'localhost/justin',
		files : [
			'dist/**/*',
			`${devPath}/views/**/*.php`,
			'app/**/*.php',
			'functions.php'
		]
	} );
}
