<?php

namespace Nova\Entry\Types;

use Nova\Controllers\Era as EraController;
use Nova\Controllers\Collection as CollectionController;
use Nova\Routing\Routes;
use Nova\App;

class Era extends Type {

	public function name() {

		return 'era';
	}

	public function path() {

		return '_eras';
	}

	public function routes() {

		$this->router->get( 'eras/{name}', EraController::class );

	//	$this->router->get( 'eras', CollectionController::class );
	}

	public function uri( $path = '' ) {

		$uri = App::resolve( 'uri/relative' ) . '/eras';

		return $path ? "{$uri}/{$path}" : $uri;
	}




}
