<?php

namespace Nova\Routing;

use Nova\App;
use Nova\Http\Request;
use Nova\Tools\Collection;

class Routes {

	protected $path = '/justin';

	protected $routes;
	protected $routers = [];
	protected $route_regexes = [];
	protected $route_vars = [];

	protected $current_route = null;

	public function __construct() {

		$this->routes = new Collection();
	}

	public function all() {

		return $this->routes;
	}

	public function get( $route, $callback, $position = 'bottom' ) {

		$router = [
			'callback' => $callback,
			'position' => $position
		];

		$this->routes[ $route ] = $callback;

		$regex = preg_replace( '/\{.*?\}/', '(.+)', $route );
		$regex = '/' . ltrim( $regex, '/' );
		$regex = str_replace( '/', '\/', $regex );
		$regex = "#{$regex}#i";

		$router['regex'] = $regex;

		preg_match_all( '/\{(.*?)\}/', $route, $matches );

		$route_vars = [];

		if ( $matches && isset( $matches[1] ) ) {

			foreach ( $matches[1] as $match ) {
				$route_vars[] = $match;
			}
		}

		$router['vars'] = $route_vars;

		if ( 'top' === $position ) {
			$this->routers = [ $route => $router ] + $this->routers;
		} else {
			$this->routers[ $route ] = $router;
		}
	}

	public function execute() {

	}

	public function currentRoute() {

		if ( is_null( $this->current_route ) ) {
			$this->current();
		}

		return $this->current_route;
	}

	public function current() {

		$request = $this->request();

		if ( '/' !== $request ) {
			$request = rtrim( $request, '/' );
		}

		if ( isset( $this->routes[ $request ] ) ) {

			if ( is_string( $this->routes[ $request ] ) ) {
				$callback = new $this->routes[ $request ];
			} else {
				$callback = $this->routes[ $request ];
			}

			$this->current_route = $request;

			return $callback();
		}

		$request_parts = explode( '/', $request );

		foreach ( $this->routers as $route => $args ) {

			if ( @preg_match( $args['regex'], $request, $matches ) ) {

				array_shift( $matches );

				$params = array_combine( $args['vars'], $matches );

				if ( is_string( $args['callback'] ) ) {
					$callback = new $args['callback'];
				}

				$this->current_route = $route;

			//	var_dump( $route );

				$callback( $params );
				return;
			}
		}
	}

	public function request() {

		return preg_replace( "#{$this->path}#", '', App::resolve( 'request' )->uri(), 1 );
	}
}
