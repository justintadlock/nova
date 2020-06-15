<?php \Nova\Engine::view( 'header', [], [ 'title' => $title ] )->display() ?>

	<div class="app-content">
		<main class="app-main">

			<?php if ( isset( $query ) ) : ?>
				<article class="entry entry--single">
					<header class="entry__header">
						<h1 class="entry__title"><?= e( $query->title() ) ?></h1>
					</header>
					<?php if ( $content = $query->content() ) : ?>
						<div class="entry__content">
							<?= $content ?>
						</div>
					<?php endif ?>
				</article>
			<?php endif ?>

			<ul>

				<?php foreach ( $entries->all() as $entry ) : ?>

					<li><a href="<?= $entry->uri() ?>"><?= $entry->title() ?></a></li>

				<?php endforeach ?>

			</ul>

			<?php \Nova\Engine::view( 'pagination', [], $data )->display() ?>

		</main>
	</div>

<?php \Nova\Engine::view( 'footer' )->display() ?>
