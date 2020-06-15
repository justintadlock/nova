<?php \Nova\Engine::view( 'header', [], [ 'title' => $title ] )->display() ?>

<div class="app-content">
	<main class="app-main">

		<?php foreach ( $entries->all() as $entry ) : ?>

			<article class="entry entry--single">

				<header class="entry__header">
					<h1 class="entry__title"><?= widow( e( $entry->title() ) ) ?></h1>
				</header>

				<div class="entry__content">
					<?= $entry->content() ?>
				</div>

			</article>

			<?php
			$current_year = $current_month = $current_day = '';

			$posts = new Nova\Entry\Entries(
				new Nova\Entry\Locator(
					Nova\ContentTypes::get( 'category' )->path()
				), [
					'number' => PHP_INT_MAX
			] ); ?>

			<ul>

			<?php foreach ( $posts->all() as $post ) : ?>

				<li><a href="<?= e( $post->uri() ) ?>"><?= e( $post->title() ) ?></a></li>

			<?php endforeach ?>

			</ul>
		</div>

		<?php endforeach ?>

	</main>
</div>

<?php \Nova\Engine::view( 'footer' )->display() ?>
