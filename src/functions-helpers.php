<?php


function path( $path = '' ) {

	$path = trim( $path, '/' );

	return $path ? Nova\App::resolve( 'path' ) . "/{$path}" : Nova\App::resolve( 'path' );
}

function uri( $path = '' ) {

	$path = trim( $path, '/' );

	return $path ? Nova\App::resolve( 'uri' ) . "/{$path}" : Nova\App::resolve( 'uri' );
}

function public_path( $path = '' ) {

	$path = trim( $path, '/' );

	return $path ? path( "public/{$path}" ) : path( 'public' );
}

function resource_path( $path = '' ) {

	$path = trim( $path, '/' );

	return $path ? path( "resources/{$path}" ) : path( 'resources' );
}

function public_uri( $path = '' ) {

	$path = trim( $path, '/' );

	return $path ? uri( "public/{$path}" ) : uri( 'public' );
}

function resource_uri( $path = '' ) {

	$path = trim( $path, '/' );

	return $path ? uri( "resources/{$path}" ) : uri( 'resources' );
}

function asset( $path ) {

	// Get the Laravel Mix manifest.
	$manifest = Nova\App::resolve( 'mix' );

	// Make sure to trim any slashes from the front of the path.
	$path = '/' . ltrim( $path, '/' );

	if ( $manifest && isset( $manifest[ $path ] ) ) {
		$path = $manifest[ $path ];
	}

	return public_uri( $path );
}

function e( $value, $double_encode = true ) {

	return htmlspecialchars( $value, ENT_QUOTES, 'UTF-8', $double_encode );
}

function widow( $text ) {
	$words = explode( ' ', $text );

	if ( 3 >= count( $words ) ) {
		return $text;
	}

	$text  = trim( $text );
	$space = strrpos( $text, ' ' );

	if ( false !== $space ) {
		$text = substr( $text, 0, $space ) . '&nbsp;' . substr( $text, $space + 1 );
	}

	return $text;
}

function request() {
	//return str_replace( '/justin/', '', $_SERVER['REQUEST_URI'] );

	$script_name = $_SERVER['SCRIPT_NAME'];
	$request_uri = $_SERVER['REQUEST_URI'];

	$basepath = implode( '/', array_slice( explode( '/', $script_name ), 0, -1 ) ) . '/';

	$uri = substr( $request_uri, strlen( $basepath ) );

	if ( strstr( $uri, '?' ) ) {
		$uri = substr( $uri, 0, strpos( $uri, '?' ) );
	}

	$uri = \Nova\Tools\Str::slashBefore( $uri );

	// Home path.
	// var_dump( trim( parse_url( \Nova\App::resolve( 'uri' ), PHP_URL_PATH ), '/' ) );

	return $uri;
}

function sanitize_slug( $slug ) {

	return sanitize_with_dashes( $slug );
}

function sanitize_with_dashes( $slug ) {

	//$slug = preg_replace( '/^[A-Za-z0-9]/i', '', $slug );
	$slug = strip_tags( $slug );
	$slug = strtolower( $slug );
	$slug = str_replace( [
		' ',
		'\s',
		'/',
		'\\'
	], '-', $slug );

	return $slug;
}

function posts_per_page() {
	return 10;
}

function cache( $name, $path = '' ) {

	$cache = \Nova\App::resolve( 'cache' );

	if ( $cache->has( $name ) ) {
		return $cache->get( $name );
	}

	$cache->add( $name, new \Nova\Cache\Cache( $name, $path ) );

	return $cache->get( $name );
}

function cache_get( $name, $path = '' ) {

	return cache( $name, $path )->get()->all();
}

function cache_set( $name, $path = '', $data = [] ) {

	cache( $name, $path )->set( $data );
}

function cache_delete( $name, $path = '' ) {

	cache( $name, $path )->delete();
}
