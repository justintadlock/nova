<article class="entry entry--single">

	<header class="entry__header max-w-2xl mx-8 sm:mx-auto">

		<div class="entry__byline text-gray-600 font-secondary text-xl">
			<?php if ( $entry->date() ) : ?>
				<?= e( $entry->date() ) ?>
			<?php endif ?>
		</div>

		<h1 class="entry__title m-0 mt-3"><?= widow( e( $entry->title() ) ) ?></h1>

		<?php if ( $subtitle = $entry->subtitle() ) : ?>
			<p class="entry__subtitle text-2xl italic color-gray-500"><?= widow( e( $subtitle ) ) ?></p>
		<?php endif ?>

	</header>

	<div class="entry__content o-content-width mt-8">
		<?= $entry->content() ?>
	</div>

	<?php if ( $topics = $entry->meta( 'category' ) ) : ?>
		<?php if ( in_array( 'wordpress-tutorials', (array) $topics ) ) : ?>
			<div class="entry__notes max-w-3xl mx-auto mt-8 p-8 font-secondary text-xl bg-blue-100 border-t-2 border-b-2 border-blue-200">
				<p>Like this tutorial? Please consider helping me write more in the future by making
				a <a href="https://paypal.me/justinleetadlock">donation via PayPal</a>,
				grabbing something from my <a href="http://a.co/02ggsr2">Amazon Wish List</a>,
				or buying <a href="<?= e( uri() ) ?>/plugindevbook">Pro WP Plugin Dev</a>.
				</p>
			</div>
		<?php elseif ( in_array( 'book-reviews', (array) $topics ) ) : ?>
			<div class="entry__notes max-w-3xl mx-auto mt-8 p-8 font-secondary text-xl bg-blue-100 border-t-2 border-b-2 border-blue-200">
				<p>Like reading my book reviews or just feeling generous? Feel free to grab
				something from my <a href="http://a.co/02ggsr2">Amazon Wish List</a>. I'll be
				happy to review it here on the blog after I read it. I'm always looking for friends on
				<a href="http://goodreads.com/justintadlock">Goodreads</a> too.</p>
			</div>
		<?php endif ?>
	<?php endif ?>

	<footer class="entry__footer clear max-w-2xl mx-8 sm:mx-auto my-8 text-gray-600 font-secondary text-xl">
		<?php if ( $entry->terms( 'category' ) ) : ?>
			<span class="entry__topics">
				Topics:
				<?php foreach ( $entry->terms( 'category' ) as $term ) : ?>
					<a class="mx-1 border-0 no-underline hover:underline" href="<?= e( $term->uri() ) ?>">#<?= e( $term->title() ) ?></a>
				<?php endforeach ?>
			</span>
		<?php endif ?>
	</footer>

</article>
