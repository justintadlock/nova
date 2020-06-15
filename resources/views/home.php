<?php \Nova\Engine::view( 'header', [], [ 'title' => ! empty( $title ) ? $title : '' ] )->display() ?>

	<div class="app-content">
		<main class="app-main">

			<?php foreach ( $entries->all() as $entry ) : ?>

				<?php \Nova\Engine::view( 'entry', [ $entry->type()->name() ], [ 'entry' => $entry ] )->display() ?>

			<?php endforeach ?>

			<?php \Nova\Engine::view( 'pagination', [], $data )->display() ?>

		</main>
	</div>

<?php \Nova\Engine::view( 'footer' )->display() ?>
