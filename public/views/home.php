<?php \Nova\Engine::view( 'header', [], [ 'title' => ! empty( $title ) ? $title : '' ] )->display() ?>

	<div class="app-content border-box overflow-hidden relative max-w-full mx-auto pt-16 text-xl leading-loose">
		<main class="app-main mx-auto mb-12 border-box">

			<?php foreach ( $entries->all() as $entry ) : ?>

				<?php \Nova\Engine::view( 'entry', [ $entry->type()->name() ], [ 'entry' => $entry ] )->display() ?>

			<?php endforeach ?>

			<?php \Nova\Engine::view( 'pagination', [], $data )->display() ?>

		</main>
	</div>

<?php \Nova\Engine::view( 'footer' )->display() ?>
