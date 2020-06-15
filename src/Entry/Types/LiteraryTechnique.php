<?php

namespace Nova\Entry\Types;

use Nova\Controllers\LiteraryTaxonomy as LiteraryTechniqueController;
use Nova\Controllers\Collection as CollectionController;
use Nova\Routing\Routes;
use Nova\App;

class LiteraryTechnique extends Type {

	public function name() {

		return 'literary_technique';
	}

	public function path() {

		return '_literary-techniques';
	}

	public function routes() {

		$this->router->get( 'writing/techniques/{name}', LiteraryTechniqueController::class );

		$this->router->get( 'writing/techniques', CollectionController::class );
	}

	public function uri( $path = '' ) {

		$uri = App::resolve( 'uri/relative' ) . '/writing/techniques';

		return $path ? "{$uri}/{$path}" : $uri;
	}




}
