<?php

namespace Nova\Http;

use Nova\Proxies\App;

class Request {

	public function uri() {
		//return str_replace( '/justin/', '', $_SERVER['REQUEST_URI'] );

		$script_name = $_SERVER['SCRIPT_NAME'];
		$request_uri = $_SERVER['REQUEST_URI'];

		$basepath = implode( '/', array_slice( explode( '/', $script_name ), 0, -1 ) ) . '/';

		$uri = substr( $request_uri, strlen( $basepath ) );

		if ( strstr( $uri, '?' ) ) {
			$uri = substr( $uri, 0, strpos( $uri, '?' ) );
		}

		$uri = \Nova\Tools\Str::slashBefore( $uri );

		$uri = preg_replace( '/[^A-Za-z0-9\/_-]/i', '', $uri );

	//	$this->maybeRedirect( $uri );

		// Home path.
		// var_dump( trim( parse_url( \Nova\App::resolve( 'uri' ), PHP_URL_PATH ), '/' ) );

		return $uri;
	}

	protected function maybeRedirect( $uri ) {

		$redirects = require_once( path( 'config/redirects.php' ) );

	//	var_dump( $redirects );

		if ( array_key_exists( $uri, $redirects['301'] ) ) {
			// Permanent 301 redirection
			header( "HTTP/1.1 301 Moved Permanently" );
			header( "Location: " . e( uri( $redirects['301'][ $uri ] ) ) . "" );
			exit();
		}
	}
}
