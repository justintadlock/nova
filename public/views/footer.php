	<footer class="app-footer py-8 font-secondary text-center text-xl border-b-2 border-blue-200">
		<p class="app-footer__credit text-gray-600">
			Powered by heart and soul.
		</p>

		<div class="menu menu--social mt-2">
			<ul class="menu__items list-none text-center p-0">
				<li class="menu__item inline-block">
					<a class="menu__link menu__link--wordpress inline-block m-3 text-gray-500 border-0" href="https://profiles.wordpress.org/greenshady"><?php include( public_path( 'svg/wordpress-simple-brands.svg.php' ) ) ?><span class="screen-reader-text">WordPress</span></a>
				</li>
				<li class="menu__item inline-block">
					<a class="menu__link menu__link--github inline-block m-3 text-gray-500 border-0" href="https://github.com/justintadlock/"><?php include( public_path( 'svg/github-brands.svg.php' ) ) ?><span class="screen-reader-text">GitHub</span></a>
				</li>
				<li class="menu__item inline-block">
					<a class="menu__link menu__link--twitter inline-block m-3 text-gray-500 border-0" href="https://twitter.com/justintadlock"><?php include( public_path( 'svg/twitter-brands.svg.php' ) ) ?><span class="screen-reader-text">Twitter</span></a>
				</li>
				<li class="menu__item inline-block">
					<a class="menu__link menu__link--facebook inline-block m-3 text-gray-500 border-0" href="https://facebook.com/justintadlock"><?php include( public_path( 'svg/facebook-brands.svg.php' ) ) ?><span class="screen-reader-text">Facebook</span></a>
				</li>
				<li class="menu__item inline-block">
					<a class="menu__link menu__link--amazon inline-block m-3 text-gray-500 border-0" href="http://a.co/02ggsr2"><?php include( public_path( 'svg/amazon-brands.svg.php' ) ) ?><span class="screen-reader-text">Amazon Wish List</span></a>
				</li>
			</ul>
		</div>
	</footer>

</div><!-- .app -->

<script>
	let menu   = document.querySelector( '.menu--primary' );
	let toggle = document.querySelector( '.toggle--menu-primary .toggle__button' );
	let burger = document.querySelector( '.toggle--menu-primary .toggle__hamburger' );
	let svg_x  = document.querySelector( '.toggle--menu-primary .toggle__x' );

	if ( null !== menu && null !== toggle ) {

		toggle.onclick = () => {
			menu.classList.toggle( 'hidden' );
			burger.classList.toggle( 'hidden' );
			svg_x.classList.toggle( 'hidden' );
		}
	}

	let blockquoteCite = document.querySelectorAll( 'blockquote > p > cite' );

	blockquoteCite.forEach( function( cite ) {
		cite.parentNode.classList.add( 'has-cite' );
	} );

	let images = document.querySelectorAll( 'img' );

	images.forEach( function( image ) {
		let classes = image.classList;

		image.onload = function() {
			if ( ( classes.contains( 'alignleft' ) || classes.contains( 'alignright' ) ) && 300 >= image.naturalWidth ) {
				classes.add( 'is-small' );
			}
		}

		if ( 'A' === image.parentElement.tagName ) {
			image.parentElement.classList.add( 'has-image' );
		}
	} );

	let paras = document.querySelectorAll( 'p' );

	paras.forEach( function( p ) {
		if ( 0 === p.clientHeight ) {
			p.classList.add( 'is-collapsed' );
		}
	} );
</script>

<?php if ( 'http://justintadlock.com' === Nova\App::resolve( 'uri' ) ) : ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-2683690-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-2683690-1');
	</script>
<?php endif ?>

</body>
</html>
