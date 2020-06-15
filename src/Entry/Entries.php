<?php

namespace Nova\Entry;

use Nova\App;

class Entries {

	protected $locator;

	protected $number = 10;
	protected $offset = 0;
	protected $order = 'asc';
	protected $orderby = 'filename';
	protected $meta_key = '';
	protected $meta_value = '';
	protected $slug = [];
	protected $year = null;
	protected $month = null;
	protected $day = null;

	protected $count = 0;
	protected $total = 0;
	protected $filenames = [];
	protected $entries = [];


	public function __construct( Locator $locator, array $args = [] ) {

		foreach ( array_keys( get_object_vars( $this ) ) as $key ) {

			if ( isset( $args[ $key ] ) ) {

				if ( 'slug' === $key ) {
					$args[ $key ] = (array) $args[ $key ];
				}

				$this->$key = $args[ $key ];
			}
		}

		$this->locator = $locator;
	}

	public function all() {

		if ( ! $this->entries ) {

			$filenames = array_keys(
				$this->sort( $this->maybeReduce( $this->locator->all() ) )
			);

			$this->total = count( $filenames );

			$this->filenames = array_slice( $filenames, $this->offset(), $this->number() );

			$this->count = count( $this->filenames );

			foreach ( $this->filenames as $filename ) {

				$this->entries[] = new Entry( $filename, $this->locator->contentType() );
			}
		}

		return $this->entries;
	}

	// @todo flesh this out for all kinds of sorting.
	private function sort( $entries ) {

		if ( 'asc' === strtolower( $this->order ) ) {
			ksort( $entries );
		} elseif ( 'desc' === strtolower( $this->order ) ) {
			krsort( $entries );
		}

		return $entries;
	}

	private function maybeReduce( $entries ) {

		$_index = App::resolve( 'path' ) . "/" . $this->locator->path() . "/_index.md";

		// Remove archive/root page if we're not specifically querying it.
		if ( ! in_array( '_index', $this->slug ) && isset( $entries[ $_index ] ) ) {
			unset( $entries[ $_index ] );
		}

		// If a slug is passed in, we're looking for a very specific
		// post. Return it or an empty array if not found.
		if ( $this->slug ) {

			$located = [];

			foreach ( $entries as $file => $matter ) {

				if ( isset( $matter['slug'] ) ) {

					if ( in_array( $matter['slug'], (array) $this->slug ) ) {

						$located[ $file ] = $matter;
						continue;
					} else {
						continue; // If file has a defined slug, always use it.
					}
				}

				$pathinfo = pathinfo( $file );

				if ( '_index' === $pathinfo['filename'] ) {
					$parts = explode( '/', $pathinfo['dirname'] );
					$dir   = array_pop( $parts );
					if ( in_array( $dir, (array) $this->slug ) ) {
						$located[ $file ] = $matter;
						continue;
					}
				}

				if ( in_array( $pathinfo['filename'], (array) $this->slug ) ) {
					$located[ $file ] = $matter;
					continue;
				}

				// Strips everything from front of string to the first `.` char.
				//$slug_from_file = ltrim( strstr( $file, '.' ), '.' );
				//$slug_from_file = str_replace( '.md', '', $file );
				$parts = explode( '.', $pathinfo['filename'] );
				if ( 1 < count( $parts ) ) {
					array_shift( $parts );
				}
				$slug_from_file = join( '', $parts );

				if ( in_array( $slug_from_file, (array) $this->slug ) ) {
					$located[ $file ] = $matter;
					continue;
				}
			}

			return $located;
		}

		if ( $this->year || $this->month || $this->day ) {
			return $this->sortByDate( $entries );
		}

		if ( ! $this->meta_value && ! $this->meta_key ) {
			return $entries;
		}

		$located = [];

		$value = sanitize_slug( $this->meta_value );

		foreach ( $entries as $filename => $matter ) {

			if ( isset( $matter[ $this->meta_key ] ) ) {

				$_v = (array) $matter[ $this->meta_key ];

				$_v = array_map( function( $x ) {
					return sanitize_slug( $x );
				}, $_v );

				if ( in_array( $value, $_v ) ) {
					$located[ $filename ] = $matter;
				}
			}
		}

		return $located;
	}

	protected function sortByDate( $entries ) {

		$located = [];

		foreach ( $entries as $file => $matter ) {

			if ( ! $matter['date'] ) {
				continue;
			}

			$timestamp = is_numeric( $matter['date'] )
				     ? $matter['date']
				     : strtotime( $matter['date'] );

			if ( $this->year && intval( $this->year ) !== intval( date( 'Y', $timestamp ) ) ) {
				continue;
			}

			if ( $this->month && intval( $this->month ) !== intval( date( 'm', $timestamp ) ) ) {
				continue;
			}

			if ( $this->day && intval( $this->day ) !== intval( date( 'd', $timestamp ) ) ) {
				continue;
			}

			$located[ $file ] = $matter;
		}

		return $located;
	}

	public function count() {
		return intval( $this->count );
	}

	public function total() {
		return intval( $this->total );
	}

	public function number() {
		return intval( $this->number );
	}

	public function offset() {
		return intval( $this->offset );
	}
}
