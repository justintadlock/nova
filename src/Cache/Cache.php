<?php

namespace Nova\Cache;

use Nova\App;
use Nova\Tools\Collection;

class Cache {

	protected $name;
	protected $path;
	protected $data;

	public function __construct( $name, $path = '' ) {

		$this->name = $name;

		$this->path = App::resolve( 'path' ) . "/user/cache";

		if ( $path ) {
			$this->path = "{$this->path}/{$path}";
		}
	}

	public function make() {

		if ( ! file_exists( $this->path() ) ) {
			mkdir( $this->path(), 0775, true );
		}
	}

	protected function path( $file = '' ) {

		$file = trim( $file, '/' );

		return $file ? "{$this->path}/{$file}" : $this->path;
	}

	protected function filename() {
		return $this->path( "/{$this->name}.json" );
	}

	public function set( $data ) {
		$this->make();

		$this->data = new Collection( $data );

		$json = preg_replace(
			[
				"/\n\s\s\s\s\s\s\s\s\s\s\s\s\s\s\s\s/",
				"/\n\s\s\s\s\s\s\s\s\s\s\s\s/",
				"/\n\s\s\s\s\s\s\s\s/",
				"/\n\s\s\s\s/"
			],
			[
				"\n\t\t\t\t",
				"\n\t\t\t",
				"\n\t\t",
				"\n\t"
			],
			json_encode( $this->data->all(), JSON_PRETTY_PRINT )
		);

		file_put_contents( $this->filename(), $json );
	}

	public function delete() {

		if ( file_exists( $this->filename() ) ) {
			unlink( $this->filename() );
		}
	}

	public function get() {

		if ( $this->data ) {
			return $this->data;
		}

		if ( file_exists( $this->filename() ) ) {

			$contents = file_get_contents( $this->filename() );

			if ( $contents ) {

				$decoded = json_decode( $contents, true );

				if ( $decoded ) {
					$this->data = new Collection( $decoded );
					return $this->data;
				}
			}
		}

		$this->data = new Collection();

		return $this->data;
	}
}
