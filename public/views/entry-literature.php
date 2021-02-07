<article class="entry">

	<header class="entry__header max-w-2xl mx-8 sm:mx-auto">
		<h2 class="entry__title">
			<a href="<?= e( $entry->uri() ) ?>"><?= e( $entry->title() ) ?></a>
		</h2>
	</header>

	<div class="entry__summary">
		<?= $entry->excerpt() ?>
	</div>

</article>
