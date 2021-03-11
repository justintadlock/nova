<?php

namespace Nova\Tools;

class Markdown extends \ParsedownExtra {

	// Matches Markdown image definition
	private $MarkdownImageRegex = "~^!\[.*?\]\(.*?\)~";

	public function __construct () {
	    // Add blockFigure to non-exclusive handlers for text starting with !
	    $this->BlockTypes['!'][] = 'Figure';
	}

	protected function inlineLink( $Excerpt ) {

		$Link = parent::inlineLink($Excerpt);

		if ( ! empty( $Link['element']['attributes']['href'] ) ) {

			if ( Str::startsWith( $Link['element']['attributes']['href'], '/' ) ) {

				$Link['element']['attributes']['href'] =
					Str::slashTrim( uri() ) .
					Str::slashBefore( $Link['element']['attributes']['href'] );
			}
		}

		return $Link;
	}

	protected function blockHeader( $Line ) {

		$Block = parent::blockHeader( $Line );

		//var_dump( $Block );

		$_text = $Block['element']['text'];

		$text = trim( $Line['text'], '# ' );

		// Check for text within a link.
		preg_match( '#\[(.*?)\]#', $text, $match );

		if ( $match && isset( $match[1] ) ) {
			$text = $match[1];
		}

		$id = str_replace( ' ', '-', $text );
		$id = preg_replace( '|%[a-fA-F0-9][a-fA-F0-9]|', '', $id );
		$id = preg_replace( '/[^A-Za-z0-9_-]/', '', $id );
		$id = strtolower( $id );

		$Block['element']['text'] = sprintf(
			'<a aria-hidden="true" href="#%1$s" id="%1$s" class="hidden sm:inline-block w-8 -ml-10 mr-2 font-secondary border-0">#</a>%2$s',
			$id,
			$_text
		);

		return $Block;
	}

	protected function blockFigure($Line) {

	    // If line does not match image def, don't handle it
	    if (1 !== preg_match($this->MarkdownImageRegex, $Line['text'])) {
		return;
	    }

	    //var_dump( $Line );

	    $InlineImage = $this->inlineImage($Line);
	    if (!isset($InlineImage)) {
		return;
	    }

	    // Lazy load images by default.
	    if ( empty( $InlineImage['element']['attributes']['loading'] ) ) {
		    $InlineImage['element']['attributes']['loading'] = 'lazy';
	    }

	    if ( ! empty( $InlineImage['element']['attributes']['class'] ) ) {
		    $classes = explode( ' ', $InlineImage['element']['attributes']['class'] );

		    $align = [
			    'alignnone',
			    'alignleft',
			    'alignright',
			    'aligncenter',
			    'alignwide',
			    'alignfull'
		    ];

		    foreach ( $classes as $key =>  $c ) {
			    if ( in_array( $c, $align, true ) ) {
				    unset( $classes[ $key ] );
				    $class = $c;
			    }
		    }

		    if ( ! empty( $classes ) ) {
		    	$InlineImage['element']['attributes']['class'] = join( ' ', $classes );
		} else {
			unset( $InlineImage['element']['attributes']['class'] );
		}
	    } else {
		    $class = 'alignnone';
	    }

	    // absolute urls.
	    if ( ! empty( $Link['element']['attributes']['src'] ) ) {

		    if ( Str::startsWith( $Link['element']['attributes']['src'], '/' ) ) {

			    $Link['element']['attributes']['src'] =
				    Str::slashTrim( uri() ) .
				    Str::slashBefore( $Link['element']['attributes']['src'] );
		    }
	    }


	    $FigureBlock = array(
		'element' => array(
		    'name' => 'figure',
		    'handler' => 'elements',
		    'text' => array(
			$InlineImage['element']
		),
		'attributes' => [
			'class' => 'block-image ' . $class
			]
		),
	    );

	    // Add figcaption if alt text set
	    if (!empty($InlineImage['element']['attributes']['title'])) {

		$InlineFigcaption = array(
		    'element' => array(
			'name' => 'figcaption',
			'text' => $InlineImage['element']['attributes']['title'],
			'attributes' => [
				'class' => 'wp-caption-text'
				]
		    ),
		);

		$FigureBlock['element']['text'][] = $InlineFigcaption['element'];
	    }

	    return $FigureBlock;
	}


}
