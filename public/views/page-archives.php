<?php \Nova\Engine::view( 'header', [], [ 'title' => $title ] )->display() ?>

<div class="app-content border-box overflow-hidden relative max-w-full mx-auto pt-16 text-xl leading-loose">
	<main class="app-main mx-auto mb-12 border-box">

		<?php foreach ( $entries->all() as $entry ) : ?>

			<article class="entry entry--single">

				<header class="entry__header max-w-2xl mx-8 sm:mx-auto">
					<h1 class="entry__title"><?= widow( e( $entry->title() ) ) ?></h1>
				</header>

				<div class="entry__content o-content-width mt-8">
					<?= $entry->content() ?>
				</div>

			</article>

			<?php
			$current_year = $current_month = $current_day = '';

			$posts = new Nova\Entry\Entries(
				new Nova\Entry\Locator(
					Nova\ContentTypes::get( 'post' )->path()
				),
				[
					'order' => 'desc',
					'number' => PHP_INT_MAX
				]
			); ?>

			<div class="archives o-content-width mt-8">

			<?php foreach ( $posts->all() as $post ) : ?>

				<?php
				$timestamp = is_numeric( $post->meta( 'date' ) ) ? $post->meta( 'date' ) : strtotime( $post->meta( 'date' ) );

				// Get the post's year and month. We need this to compare it with the previous post date.
				$year   = date( 'Y', $timestamp );
				$month  = date( 'm', $timestamp );
				$daynum = date( 'd', $timestamp );

				// If the current date doesn't match this post's date, we need extra formatting.
				if ( $current_year !== $year || $current_month !== $month ) :

					// Close the list if this isn't the first post.
					if ( $current_month && $current_year ) :
						echo '</ul>';
					endif;

					// Set the current year and month to this post's year and month.
					$current_year  = $year;
					$current_month = $month;
					$current_day   = '';

					printf(
						'<h2 class="archives__heading"><a class="text-gray-700 no-underline hover:underline border-0" href="%s">%s</a></h2>',
						\Nova\App::resolve( 'content/types' )->get( 'post' )->uri( "{$year}/{$month}" ),
						date( 'F Y', $timestamp )
					);

					// Open a new unordered list.
					echo '<ul class="archives__list list-none p-0">';
				endif;

				$day = '<span class="archives__day w-10 text-gray-500 font-mono">' . e( $daynum ) . ':</span>';

				// Check if there's a duplicate day so we can add a class.
				$duplicate_day = $current_day && $daynum === $current_day ? ' day-duplicate' : '';
				$current_day   = $daynum;

				printf(
					'<li class="archives__item flex flex-nowrap items-start justify-left ml-2 %s">%s <span class="archives__post ml-2"><a href="%s" rel="bookmark">%s</a></span></li>',
					$duplicate_day,
					$day,
					e( $post->uri() ),
					e( $post->title() )
				);

			endforeach ?>

			</ul>
		</div>

		<?php endforeach ?>

	</main>
</div>

<?php \Nova\Engine::view( 'footer' )->display() ?>
