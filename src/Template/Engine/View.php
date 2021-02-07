<?php

namespace Nova\Template\Engine;

class View {

	protected $name;
	protected $data;

	public function __construct( $name, array $slugs = [], $data = [] ) {

		$this->name = $name;
		$this->slugs = $slugs;
		$this->data = $data;
	}

	protected function locate() {

		foreach ( $this->slugs as $slug ) {

			if ( file_exists( public_path( "views/{$this->name}-{$slug}.php" ) ) ) {
				return public_path( "views/{$this->name}-{$slug}.php" );
			}
		}

		return public_path( "views/{$this->name}.php" );
	}

	public function display() {

		$data = $this->data;

		extract( $this->data );

		include( $this->locate() );
	}
}
