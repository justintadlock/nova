<?php

namespace Nova\Entry\Types;

use Nova\Controllers\Category as CategoryController;
use Nova\Controllers\Collection as CollectionController;
use Nova\Routing\Routes;
use Nova\App;

class Category extends Type {

	public function name() {

		return 'category';
	}

	public function path() {

		return '_topics';
	}

	public function routes() {

		$this->router->get( 'topics/{name}', CategoryController::class );

	//	$this->router->get( 'topics', CollectionController::class );
	}

	public function uri( $path = '' ) {

		$uri = App::resolve( 'uri/relative' ) . '/topics';

		return $path ? "{$uri}/{$path}" : $uri;
	}




}
