<?php \Nova\Engine::view( 'header', [], [ 'title' => $title ] )->display() ?>

	<div class="app-content">
		<main class="app-main">

			<?php if ( isset( $query ) ) : ?>
				<header class="archive-header">
					<h1 class="archive-header__title"><?= $query->title() ?></h1>

					<?php if ( $desc = $query->content() ) : ?>
						<div class="archive-header__description"><?= $desc ?></div>
					<?php endif ?>
				</header>
			<?php elseif ( isset( $title ) ) : ?>
				<header class="archive-header">
					<h1 class="archive-header__title"><?= e( $title ) ?></h1>
				</header>
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
