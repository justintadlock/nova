<?php

namespace Nova\Controllers;

use Nova\Entry\Entries;
use Nova\Entry\Locator;
//use Nova\Entry\Types\Post;
use Nova\Engine;

use Nova\App;

class Post {

	protected $slug;
	protected $path = '_posts';

	protected $type;

	protected $params = [];

	public function __invoke( array $params = [] ) {

		$this->params = (array) $params;

		$this->slug = $this->params['name'];

		$this->type = App::resolve( 'content/types' )->get( 'post' );

		$entries = $this->entries();

		$all = $entries->all();
		$entry = array_shift( $all );

		Engine::view( 'page', [], [
			'title'   => $entry ? $entry->title() : 'Not Found',
			'query'   => $entry ? $entry : false,
			'page'    => 1,
			'entries' => $entries
		] )->display();
	}

	protected function entries() {

		$locator = new Locator( $this->type->path() );

		return new Entries( $locator, [ 'slug' => $this->slug ] );
	}
}
