<?php \Nova\Engine::view( 'header', [], [ 'title' => $title, 'query' => ! empty( $query ) ? $query : false ] )->display() ?>

	<div class="app-content border-box overflow-hidden relative max-w-full mx-auto pt-16 text-xl leading-loose">
		<main class="app-main mx-auto mb-12 border-box">

			<?php foreach ( $entries->all() as $entry ) : ?>

				<?php \Nova\Engine::view( 'entry-single', [ $entry->type()->name() ], [ 'entry' => $entry ] )->display() ?>

			<?php endforeach ?>

		</main>
	</div>

<?php \Nova\Engine::view( 'footer' )->display() ?>
