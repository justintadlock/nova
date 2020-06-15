<?php

namespace Nova\Entry\Types;

use Nova\Controllers\Literature as Controller;
use Nova\Controllers\LiteratureArchive;
use Nova\Routing\Routes;
use Nova\App;

class Literature extends Type {

	public function name() {

		return 'literature';
	}

	public function path() {

		return '_literature';
	}

	public function routes() {

		$this->router->get( 'writing/{name}', Controller::class );
		$this->router->get( 'writing', LiteratureArchive::class );
		$this->router->get( 'writing/page/{number}', LiteratureArchive::class, 'top' );
	}

	public function uri( $path = '' ) {

		$uri = App::resolve( 'uri/relative' ) . '/writing';

		return $path ? "{$uri}/{$path}" : $uri;
	}




}
