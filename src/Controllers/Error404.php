<?php

namespace Nova\Controllers;

use Nova\Entry\Entries;
use Nova\Entry\Locator;
//use Nova\Entry\Types\Post;
use Nova\Engine;

use Nova\App;

class Error404 {

	protected $slug;
	protected $path = '_posts';

	protected $type;

	protected $params = [];

	public function __invoke( array $params = [] ) {

		http_response_code( 404 );

		$this->params = (array) $params;

		$entries = $this->entries();

		$all = $entries->all();
		$entry = array_shift( $all );

		Engine::view( 'error-404', [], [
			'title'   => $entry ? $entry->title() : 'Not Found',
			'page'    => 1,
			'entries' => $entries
		] )->display();
	}

	protected function entries() {

		$locator = new Locator( '_error' );

		return new Entries( $locator, [ 'slug' => '404' ] );
	}
}
