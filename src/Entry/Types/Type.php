<?php

namespace Nova\Entry\Types;

use Nova\Routing\Routes;

abstract class Type {

	protected $router;

	public function __construct( Routes $router ) {

		$this->router = $router;
	}

	abstract public function name();

	abstract public function routes();

	public function meta() {}

}
