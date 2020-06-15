<article class="entry">

	<header class="entry__header">
		<h2 class="entry__title">
			<a href="<?= e( $entry->uri() ) ?>"><?= e( $entry->title() ) ?></a>
		</h2>
	</header>

	<div class="entry__summary">
		<?= $entry->excerpt() ?>
	</div>

</article>
