<?php

namespace Nova\Entry\Types;

use Nova\Controllers\LiteraryTaxonomy as LiteraryFormController;
use Nova\Controllers\Collection as CollectionController;
use Nova\Routing\Routes;
use Nova\App;

class LiteraryForm extends Type {

	public function name() {

		return 'literary_form';
	}

	public function path() {

		return '_literary-forms';
	}

	public function routes() {

		$this->router->get( 'writing/forms/{name}', LiteraryFormController::class );

		$this->router->get( 'writing/forms', CollectionController::class );
	}

	public function uri( $path = '' ) {

		$uri = App::resolve( 'uri/relative' ) . '/writing/forms';

		return $path ? "{$uri}/{$path}" : $uri;
	}




}
