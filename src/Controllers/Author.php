<?php

namespace Nova\Controllers;

use Nova\Entry\Entries;
use Nova\Entry\Locator;
use Nova\Engine;
use Nova\ContentTypes;

class Author {

	protected $params = [];

	public function __invoke( array $params = [] ) {

		$this->params = (array) $params;

		$this->slug = $this->params['name'];

		$path    = ContentTypes::get( 'author' )->path();
		$locator = new Locator( $path );
		$terms = ( new Entries( $locator, [ 'slug' => $this->slug ] ) )->all();

		Engine::view( 'taxonomy', [], [
			'page'    => 1,
			'entries' => $this->entries(),
			'query'   => array_shift( $terms )
		] )->display();
	}

	protected function entries() {

		$path = ContentTypes::get( 'post' )->path();

		$locator = new Locator( $path );

		$per_page = PHP_INT_MAX;//2;//posts_per_page();
		$current = isset( $this->params['number'] ) ? intval( $this->params['number'] ) : 1;

		$args = [
			'number'     => $per_page,
			'offset'     => $per_page * ( $current - 1 ),
			'order'      => 'desc',
			'meta_key'   => 'author',
			'meta_value' => sanitize_with_dashes( $this->params['name'] )
		];

		return new Entries( $locator, $args );
	}
}
