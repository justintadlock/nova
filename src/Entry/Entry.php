<?php

namespace Nova\Entry;

use ParsedownExtra;
use Nova\Tools\Markdown;

use Michelf\SmartyPants;
use Michelf\SmartyPantsTypographer;
use Nova\Yaml\FrontMatter;
use Nova\App;
use Nova\ContentTypes;
use DateTime;

class Entry {

	protected $filename;
	protected $path;
	protected $pathinfo;
	protected $meta;
	protected $content;
	protected $datetime;
	protected $type;

	protected $resolved_meta = [];

	public function __construct( $filename, $type = 'page' ) {
		$this->filename = $filename;

		$this->pathinfo = pathinfo( $filename );

		$yaml = FrontMatter::parse( file_get_contents( $filename ) );

		$this->meta = $yaml->matter();
		$this->content = $yaml->body();

		$types = App::resolve( 'content/types' );

		if ( $types->has( $type ) ) {
			$this->type = $types->get( $type );
		}
	}

	public function filename() {
		return $this->filename;
	}

	public function type() {
		return $this->type;
	}

	public function meta( $name = '' ) {

		if ( $name ) {
			return isset( $this->meta[ $name ] ) ? $this->meta[ $name ] : false;
		}

		return $this->meta;
	}

	public function metaEntries( $name ) {

		if ( isset( $this->resolved_meta[ $name ] ) ) {
			return $this->resolved_meta[ $name ];
		}

		$this->resolved_meta[ $name ] = [];

		if ( $this->meta( $name ) ) {

			$type = ContentTypes::get( $name );

			if ( $type ) {

				$meta_values = (array) $this->meta( $name );

				$slugs = [];

				foreach ( $meta_values as $value ) {
					$slugs[] = sanitize_slug( $value );
				}

				$locator = new Locator( $type->path() );

				$entries = new Entries( $locator, [ 'slug' => $slugs ] );

				if ( $entries->all() ) {
					$this->resolved_meta[ $name ] = $entries->all();
				}
			}
		}

		return $this->resolved_meta[ $name ];
	}

	public function title() {

		return $this->meta( 'title' );
	}

	public function subtitle() {

		return $this->meta( 'subtitle' );
	}

	public function date() {

		if ( ! $this->meta( 'date' ) ) {
			return '';
		}

		$timestamp = is_numeric( $this->meta( 'date' ) )
		             ? $this->meta( 'date' )
			     : strtotime( $this->meta( 'date' ) );

		return date( 'F j, Y', $timestamp );
	}

	private function config( $key = '' ) {
		$config = App::resolve( 'config/entry' );

		if ( $key ) {
			return isset( $config[ $key ] ) ? $config[ $key ] : false;
		}

		return $config;
	}

	public function author() {

		$authors = $this->authors();

		return $authors ? array_shift( $authors ) : '';
	}

	public function authors() {

		return $this->metaEntries( 'author' );
	}

	public function terms( $taxonomy ) {

		return $this->metaEntries( $taxonomy );
	}

	protected function parseContent( $content ) {

		$parsedown = new Markdown();

		$content = preg_replace(
			"/{{.+?media\(.+?['\"](.+?)['\"].+?\).+?}}/i",
			App::resolve( 'uri/relative' ) . "/user/media/$1",
			$content
		);

		$content = $parsedown->setBreaksEnabled(true)->text( $content );

		// Fix Parsedown's replacement of tabs with 4 spaces.
		// @link https://github.com/erusev/parsedown/issues/363#issuecomment-155214220
		$content = preg_replace_callback( '/^[ ]{4,}/m', function( $m ) {
			return preg_replace('/[ ]{4}/', "\t", $m[0] );
		}, $content );

		// @link https://michelf.ca/projects/php-smartypants/configuration/
		return SmartyPantsTypographer::defaultTransform( $content, "q/d/e/w" );
	}

	public function content() {

		return $this->parseContent( $this->content );
	}

	public function uri() {

		$uri = $this->meta( 'uri' );

		if ( ! $uri ) {
			$uri = $this->meta( 'uri' );
		}

		if ( ! $uri ) {
			$uri = $this->meta( 'slug' );
		}

		if ( ! $uri ) {
			$parts = explode( '.', $this->pathinfo['filename'] );
			if ( 1 < count( $parts ) ) {
				array_shift( $parts );
			}
			$uri = join( '', $parts );
		//	$uri = preg_replace( "/\d{4}-\d{2}-\d{2}./", '', $this->pathinfo['filename'] );
		}

		if ( $this->type ) {

			if ( 'post' === $this->type->name() ) {

				$timestamp = is_numeric( $this->meta( 'date' ) )
					     ? $this->meta( 'date' )
					     : strtotime( $this->meta( 'date' ) );

				return $this->type->uri(
					date( 'Y/m/d', $timestamp ) . '/' . $uri
				);
			}

			return $this->type->uri( $uri );
		}

		$path = str_replace(
			[
				App::resolve( 'path' ) . '/',
				'user/content/',
				$this->pathinfo['basename']
			],
			'',
			$this->filename
		);

		$path = trim( $path, '/' );

		return App::resolve( 'uri/relative' ) . "/{$path}/{$uri}";
	}

	public function excerpt( $length = 40, $more = '&hellip;' ) {

		$content = $this->content();

		if ( $this->meta( 'excerpt' ) ) {
			return $this->parseContent( $this->meta( 'excerpt' ) );
		}

		$excerpt = strip_tags( trim( $content ) );
		$words = str_word_count( $excerpt, 2 );
		if ( count( $words ) > $length ) {
			$words = array_slice( $words, 0, $length, true );
			end( $words );
			$position = key( $words ) + strlen( current( $words ) );
			$excerpt = substr( $excerpt, 0, $position ) . $more;
		}
		return $excerpt ? '<p>' . $excerpt . '</p>' : '';
	}
}
