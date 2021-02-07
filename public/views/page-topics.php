<?php \Nova\Engine::view( 'header', [], [ 'title' => $title ] )->display() ?>

<div class="app-content border-box overflow-hidden relative max-w-full mx-auto pt-16 text-xl leading-loose">
	<main class="app-main mx-auto mb-12 border-box">

		<?php foreach ( $entries->all() as $entry ) : ?>

			<article class="entry entry--single">

				<header class="entry__header max-w-2xl mx-8 sm:mx-auto">
					<h1 class="entry__title"><?= widow( e( $entry->title() ) ) ?></h1>
				</header>

				<div class="entry__content o-content-width mt-8">
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

			<div class="o-content-width mt-8">

				<ul>

				<?php foreach ( $posts->all() as $post ) : ?>

					<li><a href="<?= e( $post->uri() ) ?>"><?= e( $post->title() ) ?></a></li>

				<?php endforeach ?>

				</ul>

			</div>
		</div>

		<?php endforeach ?>

	</main>
</div>

<?php \Nova\Engine::view( 'footer' )->display() ?>
