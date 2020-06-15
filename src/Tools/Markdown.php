<?php

namespace Nova\Tools;

class Markdown extends \ParsedownExtra
{

	// Matches Markdown image definition
	private $MarkdownImageRegex = "~^!\[.*?\]\(.*?\)~";

	public function __construct () {
	    // Add blockFigure to non-exclusive handlers for text starting with !
	    $this->BlockTypes['!'][] = 'Figure';
	}

	protected function blockFigure($Line) {

	    // If line does not match image def, don't handle it
	    if (1 !== preg_match($this->MarkdownImageRegex, $Line['text'])) {
		return;
	    }

	    var_dump( $Line );

	    $InlineImage = $this->inlineImage($Line);
	    if (!isset($InlineImage)) {
		return;
	    }

	    $FigureBlock = array(
		'element' => array(
		    'name' => 'figure',
		    'handler' => 'elements',
		    'text' => array(
			$InlineImage['element']
		),
		'attributes' => [
			'class' => 'wp-caption'
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
