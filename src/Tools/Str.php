<?php

namespace Nova\Tools;

class Str {

	public static function slashBefore( $str ) {

		return '/' . ltrim( $str, '/' );
	}

	public static function slashAfter( $str ) {

		return rtrim( $str, '/' ) . '/';
	}

	public static function slashTrim( $str ) {

		return trim( $str, '/' );
	}

	public static function startsWith( $str, $starts ) {

		return substr( $str, 0, strlen( $starts ) ) === $starts;
	}
}
