<?php \Nova\Engine::view( 'header', [], [ 'title' => $title, 'query' => ! empty( $query ) ? $query : false ] )->display() ?>

	<div class="app-content">
		<main class="app-main">

			<?php foreach ( $entries->all() as $entry ) : ?>

				<?php \Nova\Engine::view( 'entry-single', [ $entry->type()->name() ], [ 'entry' => $entry ] )->display() ?>

			<?php endforeach ?>

		</main>
	</div>

<?php \Nova\Engine::view( 'footer' )->display() ?>
