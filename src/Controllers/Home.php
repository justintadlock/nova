<?php

namespace Nova\Controllers;

use Nova\Entry\Entries;
use Nova\Entry\Locator;
use Nova\Engine;

class Home {

	protected $params;

	public function __invoke( array $params = [] ) {

		$this->params = $params;

		Engine::view( 'home', [], [
			'page'    => isset( $this->params['number'] ) ? intval( $this->params['number'] ) : 1,
			'entries' => $this->entries(),
			'title'   => 'Justin Tadlock: Life & Stuff'
		] )->display();
	}

	protected function entries() {

		// regular page - _index.md
		$locator = new Locator();

		$entries = new Entries( $locator, [ 'slug' => '_index' ] );

		if ( $entries->all() ) {
			return $entries;
		}

		// blog posts

		$path = '_posts';

		$locator = new Locator( $path );

		$per_page = posts_per_page();
		$current  = isset( $this->params['number'] ) ? intval( $this->params['number'] ) : 1;

		$args = [
			'number' => $per_page,
			'offset' => $per_page * ( $current - 1 ),
			'order'  => 'desc',
		//	'orderby' => 'date'
		];

		return new Entries( $locator, $args );
	}
}
