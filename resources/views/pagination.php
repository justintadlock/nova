<?php

if ( $entries->total() > $entries->count() ) {

	$request = preg_replace( '/\/page\/\d+/', '', request() );

	$dots = false;

	$current = intval( $data['page'] );
	$end_size = 1;
	$mid_size = 1;
	$total = ceil( $entries->total() / $entries->number() );

	echo '<nav class="pagination">';

	echo '<ul class="pagination__items">';

	if ( 1 < $current ) {
		if ( 2 < $current ) {
			$page = $current - 1;
			$uri = Nova\App::resolve( 'uri/relative' ) . rtrim( $request, '/' ) . '/page/' . $page;
		} else {
			$uri = Nova\App::resolve( 'uri/relative' ) . rtrim( $request, '/' );
		}

		echo '<li class="pagination__item pagination__item--prev"><a class="pagination__anchor pagination__anchor--link" href="' . e( $uri ) . '">&larr; Previous</a>';
	}


	for ( $i = 1; $i <= ceil( $entries->total() / $entries->number() ); $i++ ) {

		if ( $current === $i ) {
			echo '<li class="pagination__item pagination__item--num pagination__item--current"><span class="pagination__anchor pagination__anchor--current">' . $i . '</span></li>';
			$dots = true;
		} else {

			if ( $i <= $end_size || ( $current && $i >= $current - $mid_size && $i <= $current + $mid_size ) || $i > $total - $end_size ) {


				if ( 1 != $i ) {
					$uri = Nova\App::resolve( 'uri/relative' ) . rtrim( $request, '/' ) . '/page/' . $i;
				} else {
					$uri = Nova\App::resolve( 'uri/relative' ) . rtrim( $request, '/' );
				}

				echo '<li class="pagination__item pagination__item--num"><a class="pagination__anchor pagination__anchor--link" href="' . e( $uri ) . '">' . $i . '</a>';
				$dots = true;

			} elseif ( $dots ) {
				echo '<li class="pagination__item pagination__item--dots"><span class="pagination__anchor pagination__anchor--dots">&hellip;</span></li>';
				$dots = false;
			}
		}
	}

	if ( $current < $total ) {
			$page = $current + 1;
			$uri = Nova\App::resolve( 'uri/relative' ) . rtrim( $request, '/' ) . '/page/' . $page;


		echo '<li class="pagination__item pagination__item--next"><a class="pagination__anchor pagination__anchor--link" href="' . e( $uri ) . '">Next &rarr;</a>';
	}

	echo '</ul>';
	echo '</nav>';
}
