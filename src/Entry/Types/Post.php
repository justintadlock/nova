<?php

namespace Nova\Entry\Types;

use Nova\Controllers\Post as PostController;
use Nova\Controllers\PostDayArchive;
use Nova\Controllers\PostMonthArchive;
use Nova\Controllers\PostYearArchive;
use Nova\Routing\Routes;
use Nova\App;

class Post extends Type {

	public function name() {

		return 'post';
	}

	public function path() {

		return '_posts';
	}

	public function routes() {

		$this->router->get( 'archives/{year}/{month}/{day}/{name}', PostController::class );
		$this->router->get( 'archives/{year}/{month}/{day}', PostDayArchive::class );
		$this->router->get( 'archives/{year}/{month}', PostMonthArchive::class );
		$this->router->get( 'archives/{year}', PostYearArchive::class );

	//	$this->router->get( 'posts/{name}', Controller::class );
	}

	public function uri( $path = '' ) {

		$uri = App::resolve( 'uri' ) . '/archives';

		return $path ? "{$uri}/{$path}" : $uri;
	}




}
