<?php

require_once( 'vendor/autoload.php' );


/* === Application === */

date_default_timezone_set( 'America/Chicago' );

define( 'NOVA_DIR', __DIR__ );

$nova = new \Nova\Core\Application();

$config = require_once( 'config.php' );

$nova->instance( 'path', NOVA_DIR );
$nova->instance( 'uri', $config['uri'] );
$nova->instance( 'uri/relative', parse_url( $nova->uri, PHP_URL_PATH ) );
$nova->instance( 'routes', new \Nova\Routing\Routes() );
$nova->singleton( 'cache', function() {
	return new \Nova\Tools\Collection();
} );
$nova->instance( 'config/entry', require_once( $nova->path . '/config/entry.php' ) );
$nova->instance( 'path/content', 'user/content' );
$nova->singleton( 'template/engine', \Nova\Template\Engine\Engine::class );
$nova->singleton( 'content/types', function() {
	return new \Nova\Entry\Types();
} );

$nova->instance( 'cache/meta', [ 'date', 'category', 'era', 'slug' ] );

$nova->singleton( 'mix', function( $app ) {

	$file = "{$app->path}/public/mix-manifest.json";

	return file_exists( $file ) ? json_decode( file_get_contents( $file ), true ) : null;
} );

$nova->singleton( 'request', \Nova\Http\Request::class );

$nova->proxy( \Nova\Proxies\Engine::class, '\Nova\Engine' );
$nova->proxy( \Nova\Proxies\ContentTypes::class, '\Nova\ContentTypes' );

$nova->boot();

/* === Routes === */

$nova->routes->get( 'feed', \Nova\Controllers\Feed::class, 'top' );

$nova->routes->get( 'page/{number}', \Nova\Controllers\Home::class, 'top' );

\Nova\ContentTypes::add( 'post', new \Nova\Entry\Types\Post( $nova->routes ) );

\Nova\ContentTypes::add( 'category', new \Nova\Entry\Types\Category( $nova->routes ) );

\Nova\ContentTypes::add( 'era', new \Nova\Entry\Types\Era( $nova->routes ) );

\Nova\ContentTypes::add( 'author', new \Nova\Entry\Types\Author( $nova->routes ) );

\Nova\ContentTypes::add( 'literature', new \Nova\Entry\Types\Literature( $nova->routes ) );

\Nova\ContentTypes::add( 'page', new \Nova\Entry\Types\Page( $nova->routes ) );

\Nova\ContentTypes::registerRoutes();

$nova->routes->get( '/', \Nova\Controllers\Home::class );

/* === Launch === */

if ( isset( $_GET['bust-cache'] ) ) {

	if ( 'all' === $_GET['bust-cache'] ) {

		$files = glob( $nova->resolve( 'path' ) . "/user/cache/content/*.json" );

		foreach ( $files as $filename ) {
			unlink( $filename );
		}
	} else {
		$path = $nova->resolve( 'path' ) . '/user/cache';

		$name = preg_replace( '/[^A-Za-z0-9\/_-]/i', '', $_GET['bust-cache'] );

		if ( file_exists( "{$path}/{$name}.json" ) ) {
			unlink( "{$path}/{$name}.json" );
		}
	}
}

// Check if ob_gzhandler already loaded
if ( ini_get( 'output_handler' ) !== 'ob_gzhandler' ) {
	if ( extension_loaded( 'zlib' ) ) {
		if ( ! ob_start( 'ob_gzhandler' ) ) {
			ob_start();
		}
	}
}

// Launch the current controller.
$current = $nova->routes->current();
