<?php $format = $entry->meta( 'format' ); ?>

<article class="entry entry--format-<?= $format ? e( $format ) : 'standard' ?>">

	<?php if ( 'aside' !== $format ) : ?>

		<header class="entry__header">

			<h2 class="entry__title">
				<a href="<?= e( $entry->uri() ) ?>"><?= e( $entry->title() ) ?></a>
			</h2>

			<div class="entry__byline">
				<?php if ( $entry->author() ) : ?>
					Written by <a href="about"><?= e( $entry->author()->title() ) ?></a>
				<?php endif ?>

				<?php if ( $entry->date() ) : ?>
					on <?= e( $entry->date() ) ?>
				<?php endif ?>
			</div>

		</header>

	<?php endif ?>

	<?php if ( 'aside' === $format ) : ?>
		<div class="entry__content">
			<?= $entry->content() ?>
		</div>
	<?php else : ?>
		<div class="entry__summary">
			<?= $entry->excerpt() ?>
		</div>
	<?php endif ?>

</article>
