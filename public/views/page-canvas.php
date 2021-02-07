<?php \Nova\Engine::view( 'header', [], [ 'title' => $title, 'query' => ! empty( $query ) ? $query : false ] )->display() ?>

	<div class="app-content border-box overflow-hidden relative max-w-full mx-auto text-xl leading-loose">
		<main class="app-main mx-auto mb-12 border-box">

			<?php foreach ( $entries->all() as $entry ) : ?>

				<div class="entry__content o-content-width">
					<?= $entry->content() ?>
				</div>

			<?php endforeach ?>

		</main>
	</div>

<?php \Nova\Engine::view( 'footer' )->display() ?>
