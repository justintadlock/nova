<article class="entry entry--single">

	<header class="entry__header max-w-2xl mx-8 sm:mx-auto">
		<h1 class="entry__title m-0"><?= widow( e( $entry->title() ) ) ?></h1>
	</header>

	<div class="entry__content o-content-width mt-12">
		<?= $entry->content() ?>
	</div>

</article>
