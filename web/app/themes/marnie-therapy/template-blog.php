<?php
/**
 * Template Name: Blog
 *
 * Blog index: lists published posts as cards. Assign this template to
 * whichever page should act as the site's blog listing (e.g. a page
 * titled "Blog").
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" tabindex="-1">
	<div class="container section">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<header class="blog-header">
				<h1><?php the_title(); ?></h1>
			</header>
			<?php
		endwhile;

		// A Page's own pagination query var is "page" (reserved for
		// <!--nextpage--> splits); "paged" only appears on true archives.
		// This custom query needs whichever one the rewrite rules set.
		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );

		$blog_query = new WP_Query(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'paged'          => $paged,
				'posts_per_page' => get_option( 'posts_per_page' ),
			)
		);
		?>

		<?php if ( $blog_query->have_posts() ) : ?>
			<div class="blog-grid">
				<?php
				while ( $blog_query->have_posts() ) :
					$blog_query->the_post();
					?>
					<article <?php post_class( 'blog-card' ); ?>>
						<a class="blog-card__link" href="<?php the_permalink(); ?>">
							<div class="blog-card__thumb<?php echo has_post_thumbnail() ? '' : ' blog-card__thumb--placeholder'; ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php
									the_post_thumbnail(
										'blog-card-lg',
										array(
											'sizes'    => '(min-width: 64rem) 33vw, (min-width: 40rem) 50vw, 100vw',
											'loading'  => 'lazy',
											'decoding' => 'async',
											'alt'      => get_the_title(),
										)
									);
									?>
								<?php else : ?>
									<svg width="48" height="48" viewBox="0 0 100 100" aria-hidden="true" focusable="false">
										<path fill="#cddabd" d="M50 38c-6-14-24-24-36-16-11 8-9 26 6 32 10 4 22 2 30-6 8 8 20 10 30 6 15-6 17-24 6-32-12-8-30 2-36 16z"/>
									</svg>
								<?php endif; ?>
							</div>
							<div class="blog-card__body">
								<p class="blog-card__date"><?php echo esc_html( get_the_date() ); ?></p>
								<h2 class="blog-card__title"><?php the_title(); ?></h2>
								<p class="blog-card__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
							</div>
						</a>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<?php
			$links = paginate_links(
				array(
					'total'     => $blog_query->max_num_pages,
					'current'   => $paged,
					'prev_text' => __( '← Newer', 'marnie-therapy' ),
					'next_text' => __( 'Older →', 'marnie-therapy' ),
					'type'      => 'list',
				)
			);
			if ( $links ) :
				?>
				<nav class="pagination" aria-label="<?php esc_attr_e( 'Blog pages', 'marnie-therapy' ); ?>">
					<?php echo wp_kses_post( $links ); ?>
				</nav>
				<?php
			endif;
			?>
		<?php else : ?>
			<p><?php esc_html_e( 'No posts yet — check back soon.', 'marnie-therapy' ); ?></p>
		<?php endif; ?>

		<?php wp_reset_postdata(); ?>
	</div>
</main>

<?php get_footer(); ?>
