<?php \Nova\Engine::view( 'header', [], [ 'title' => $title ] )->display() ?>

	<div class="app-content border-box overflow-hidden relative max-w-full mx-auto pt-16 text-xl leading-loose">
		<main class="app-main mx-auto mb-12 border-box">

			<?php if ( isset( $query ) ) : ?>
				<article class="entry entry--single">
					<header class="entry__header max-w-2xl mx-8 sm:mx-auto">
						<h1 class="entry__title"><?= e( $query->title() ) ?></h1>
					</header>
					<?php if ( $content = $query->content() ) : ?>
						<div class="entry__content o-content-width mt-8">
							<?= $content ?>
						</div>
					<?php endif ?>
				</article>
			<?php endif ?>

			<div class="collection-list o-content-width mt-8">

				<ul>

					<?php foreach ( $entries->all() as $entry ) : ?>

						<li><a href="<?= $entry->uri() ?>"><?= $entry->title() ?></a></li>

					<?php endforeach ?>

				</ul>

			</div>

			<?php \Nova\Engine::view( 'pagination', [], $data )->display() ?>

		</main>
	</div>

<?php \Nova\Engine::view( 'footer' )->display() ?>
