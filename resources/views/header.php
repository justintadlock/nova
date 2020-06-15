<!DOCTYPE html>
<html>
<head>
	<title><?php
		$route = Nova\App::resolve( 'routes' )->currentRoute();
		$paged = '';
		$title_tag = 'p';

		if ( false !== strpos( $route, 'page/{number}' ) ) {
			$p = explode( '/', Nova\App::resolve( 'request' )->uri() );
			$paged = ': Page ' . e( array_pop( $p ) );
		}

		if ( '/' === $route || 'page/{number}' === $route ) {
			echo ! empty( $title ) ? e( $title ) . $paged : 'Justin Tadlock';
			$title_tag = 'h1';
		} else {
			echo ! empty( $title ) ? e( $title ) . $paged . ' &mdash; Justin Tadlock' : 'Justin Tadlock';
		}
	?></title>
	<base href="<?= e( uri() ) ?>/">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?= e( asset( 'css/screen.css' ) ) ?>" />
	<?php if ( ! empty( $query ) ) :
		if ( $desc = $query->meta( 'description' ) ) :
	?><meta name="description" value="<?= e( $desc ) ?>" />
	<?php elseif ( $desc = $query->excerpt( 40, '' ) ) :
			$desc = strip_tags( $desc );
			$desc = str_replace( [ "\n", "\r", "\t" ], ' ', $desc );
			$desc = e( $desc );
			$desc = 260 > strlen( $desc ) ? substr( $desc, 0, 260 ) . '&hellip;' : $desc;
	?><meta name="description" value="<?= trim( $desc ) ?>" />
	<meta property="og:description" content="<?= trim( $desc ) ?>" />
		<?php endif;
		if ( $keywords = $query->meta( 'keywords' ) ) :
?>
	<meta name="keywords" value="<?= e( $keywords ) ?>" />
<?php endif;
		if ( $thumbnail = $query->meta( 'thumbnail' ) ) :
			$thumbnail = false === strpos( $thumbnail, 'http://' ) ? "http://justintadlock.com{$thumbnail}" : $thumbnail; ?>
	<meta property="og:image" content="<?= e( $thumbnail ) ?>" />
	<meta name="twitter:image" content="<?= e( $thumbnail ) ?>" />
	<meta name="twitter:card" content="summary_large_image" />
<?php endif;
endif; ?>
	<meta name="twitter:creator" content="@justintadlock" />
	<meta name="twitter:site" content="@justintadlock" />
	<meta name="twitter:text:title" content="<?= ! empty( $title ) ? e( $title ) : 'Justin Tadlock' ?>" />
	<link rel="alternate" type="application/rss+xml" title="Justin Tadlock Feed" href="http://feeds.feedburner.com/JustinTadlock" />
</head>
<body>

<div class="app">

	<header class="app-header">
		<<?= e( $title_tag ) ?> class="app-header__title">
			<a class="app-header__title-link" href="<?= e( uri() ) ?>">Justin Tadlock</a>
		</<?= e( $title_tag ) ?>>

		<nav class="menu menu--primary">
			<h3 class="menu__title"><button class="menu__toggle"><?php include( public_path( 'svg/bars-solid.svg.php' ) ) ?><span class="screen-reader-text">View Navigation</span></button></h3>
			<ul class="menu__items">
				<li class="menu__item"><a class="menu__anchor" href="about">About</a></li>
				<li class="menu__item"><a class="menu__anchor" href="archives">Archives</a></li>
				<li class="menu__item"><a class="menu__anchor" href="contact">Contact</a></li>
				<li class="menu__item"><a class="menu__anchor" href="services">Hire Me</a></li>
				<li class="menu__item"><a class="menu__anchor" href="writing">Writing</a></li>
				<li class="menu__item"><a class="menu__anchor" href="http://feeds.feedburner.com/JustinTadlock">Subscribe</a></li>
			</ul>
		</nav>

	</header>

	<div class="below-app-header">

		<div class="overlay"></div>
