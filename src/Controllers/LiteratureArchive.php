<?php

namespace Nova\Controllers;

use Nova\Entry\Entries;
use Nova\Entry\Locator;
use Nova\Engine;
use Nova\ContentTypes;

class LiteratureArchive {

	protected $params;

	public function __invoke( array $params = [] ) {

		$this->params = $params;

		$path    = ContentTypes::get( 'literature' )->path();
		$locator = new Locator( $path );
		$terms = ( new Entries( $locator, [ 'slug' => '_index' ] ) )->all();

		Engine::view( 'collection', [], [
			'title'   => 'Writing',
			'query'   => array_shift( $terms ),
			'page'    => isset( $this->params['number'] ) ? intval( $this->params['number'] ) : 1,
			'entries' => $this->entries()
		] )->display();
	}

	protected function entries() {

		$path = '_literature';

		$locator = new Locator( $path );

		//$per_page = posts_per_page();
		$per_page = PHP_INT_MAX;//posts_per_page();
		//$current  = $this->page;//intval( trim( preg_replace( '/.*?page\/([\d]).*?/i', '$1', request() ), '/' ) );
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
