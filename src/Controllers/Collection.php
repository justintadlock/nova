<?php

namespace Nova\Controllers;

use Nova\Entry\Entries;
use Nova\Entry\Locator;
use Nova\Engine;

class Collection {

	public function __invoke() {

		Engine::view( 'collection', [], [
			'page'    => 1,
			'entries' => $this->entries()
		] )->display();
	}

	protected function entries() {

		$path = 'posts';

		$locator = new Locator( request() );

		$per_page = posts_per_page();
		$current  = intval( trim( preg_replace( '/.*?page\/([\d]).*?/i', '$1', request() ), '/' ) );
		$current  = $current ?: 1;

		$request = explode( '/', request() );

		$args = [
			'number'     => $per_page,
			'offset'     => $per_page * ( $current - 1 ),
			'order'      => 'desc'
		];

		return new Entries( $locator, $args );
	}
}
