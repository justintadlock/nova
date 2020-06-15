		<footer class="app-footer">
			<p class="app-footer__credit">
				Powered by heart and soul.
			</p>

			<div class="menu menu--social">
				<ul class="menu__items">
					<li class="menu__item">
						<a class="menu__anchor" href="https://profiles.wordpress.org/greenshady"><?php include( public_path( 'svg/wordpress-simple-brands.svg.php' ) ) ?><span class="screen-reader-text">WordPress</span></a>
						<a class="menu__anchor" href="https://github.com/justintadlock/"><?php include( public_path( 'svg/github-brands.svg.php' ) ) ?><span class="screen-reader-text">GitHub</span></a>
						<a class="menu__anchor" href="https://twitter.com/justintadlock"><?php include( public_path( 'svg/twitter-brands.svg.php' ) ) ?><span class="screen-reader-text">Twitter</span></a>
						<a class="menu__anchor" href="https://facebook.com/justintadlock"><?php include( public_path( 'svg/facebook-brands.svg.php' ) ) ?><span class="screen-reader-text">Facebook</span></a>
						<a class="menu__anchor" href="http://a.co/02ggsr2"><?php include( public_path( 'svg/amazon-brands.svg.php' ) ) ?><span class="screen-reader-text">Amazon Wish List</span></a>
					</li>
				</ul>
			</div>
		</footer>

	</div><!-- .below-app-header -->

</div><!-- .app -->

<script>
	let body       = document.body;
	let menu       = document.querySelector( '.menu--primary' );
	let menuButton = document.querySelector( '.menu--primary .menu__toggle' );

	menuButton.onclick = function() {
		body.classList.toggle( 'menu-open' );
		menu.classList.toggle( 'is-open' );
		menuButton.classList.toggle( 'is-active' );
	};

	document.onclick = function() {
		body.classList.remove( 'menu-open' );
		menu.classList.remove( 'is-open' );
		menuButton.classList.remove( 'is-active' );
	};

	menu.onclick = function( e ) {
		e.stopPropagation();
	};

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
