<?php

namespace Nova\Entry\Types;

use Nova\Controllers\LiteraryTaxonomy as LiteraryGenreController;
use Nova\Controllers\Collection as CollectionController;
use Nova\Routing\Routes;
use Nova\App;

class LiteraryGenre extends Type {

	public function name() {

		return 'literary_genre';
	}

	public function path() {

		return '_literary-genres';
	}

	public function routes() {

		$this->router->get( 'writing/genres/{name}', LiteraryGenreController::class );

		$this->router->get( 'writing/genres', CollectionController::class );
	}

	public function uri( $path = '' ) {

		$uri = App::resolve( 'uri/relative' ) . '/writing/genres';

		return $path ? "{$uri}/{$path}" : $uri;
	}




}
