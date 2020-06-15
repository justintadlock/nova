<article class="entry entry--single">

	<header class="entry__header">
		<h1 class="entry__title"><?= widow( e( $entry->title() ) ) ?></h1>

		<?php if ( $subtitle = $entry->subtitle() ) : ?>
			<p class="entry__subtitle"><?= widow( e( $subtitle ) ) ?></p>
		<?php endif ?>

		<div class="entry__byline">

			<?php if ( $entry->author() ) : ?>
				Written by <a class="entry__author" href="about"><?= e( $entry->author()->title() ) ?></a>
			<?php endif ?>

			<?php if ( $entry->date() ) : ?>
				on <?= e( $entry->date() ) ?>
			<?php endif ?>

		</div>

	</header>

	<div class="entry__content">
		<?= $entry->content() ?>
	</div>

	<?php if ( $topics = $entry->meta( 'category' ) ) : ?>
		<?php if ( in_array( 'wordpress-tutorials', (array) $topics ) ) : ?>
			<div class="entry__notes">
				<p>Like this tutorial? Please consider helping me write more in the future by making
				a <a href="https://paypal.me/justinleetadlock">donation via PayPal</a>,
				grabbing something from my <a href="http://a.co/02ggsr2">Amazon Wish List</a>,
				or signing up at <a href="https://themehybrid.com">Theme Hybrid</a>
				where you can ask me any support questions you want.</p>
			</div>
		<?php elseif ( in_array( 'book-reviews', (array) $topics ) ) : ?>
			<div class="entry__notes">
				<p>Like reading my book reviews or just feeling generous? Feel free to grab
				something from my <a href="http://a.co/02ggsr2">Amazon Wish List</a>. I'll be
				happy to review it here on the blog after I read it. I'm always looking for friends on
				<a href="http://goodreads.com/justintadlock">Goodreads</a> too.</p>
			</div>
		<?php endif ?>
	<?php endif ?>

	<footer class="entry__footer">
		<?php if ( $entry->terms( 'category' ) ) : ?>
			<span class="entry__topics">
				Topics:
				<?php foreach ( $entry->terms( 'category' ) as $term ) : ?>
					<a href="<?= e( $term->uri() ) ?>">#<?= e( $term->title() ) ?></a>
				<?php endforeach ?>
			</span>
		<?php endif ?>
	</footer>

</article>
