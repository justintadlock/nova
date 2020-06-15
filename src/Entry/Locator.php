<?php

namespace Nova\Entry;

use Nova\App;
use Nova\Yaml\FrontMatter;

class Locator {

	protected $path;

	protected $cache;

	protected $cache_key = 'content';
	protected $cache_path = 'content';

	protected $content_type = 'page';

	public function __construct( $path = '' ) {

		// Remove slashes and dots from the left/right sides.
		$path = trim( $path, '/.' );

		$this->path = App::resolve( 'path/content' );

		foreach ( App::resolve( 'content/types' ) as $type ) {

			if ( $path === $type->path() ) {
				$this->content_type = $type->name();
				break;
			}
		}

		if ( $path ) {
			$this->path .= "/{$path}";
		}

		// Use the path to build the cache key/name, such as
		// `{$cache_key}.json`.
		if ( $path ) {
			$this->cache_key = $path;
		}
	}

	public function path() {
		return $this->path;
	}

	protected function getCache() {

		if ( ! $this->cache ) {
			$this->cache = cache_get( $this->cache_key, $this->cache_path );
		}

		return $this->cache;
	}

	protected function setCache( $data ) {

		cache_set( $this->cache_key, $this->cache_path, $data );

		$this->cache = $data;
	}

	public function contentType() {
		return $this->content_type;
	}

	public function all() {

		$entries = $this->getCache();

		if ( ! $entries ) {
			$entries = $this->locate();
		}

		$located = [];

		foreach ( (array) $entries as $filename => $data ) {

			$filename = App::resolve( 'path' ) . "/{$this->path}/{$filename}";

			$located[ $filename ] = $data;
		}

		return $located;
	}

	protected function locate() {

		$files = glob( App::resolve( 'path' ) . "/{$this->path}/*.md" );

		if ( ! $files ) {
			return [];
		}

		// Get the metadata keys that we want to cache.
		$cache_meta_keys = array_flip( App::resolve( 'cache/meta' ) );

		foreach ( $files as $file ) {

			$data     = [];
			$contents = file_get_contents( $file );

			if ( $contents ) {
				$yaml = FrontMatter::parse( $contents );
				$_data = $yaml->matter();

				// only cache the data that we need.
				$data = array_intersect_key( $_data, $cache_meta_keys );
			}

			$filename = str_replace( App::resolve( 'path' ) . "/{$this->path}/", '', $file );

			$cache[ $filename ] = $data;
		}

		if ( $cache ) {
			$this->setCache( $cache );
			return $cache;
		}

		return [];
	}
}
