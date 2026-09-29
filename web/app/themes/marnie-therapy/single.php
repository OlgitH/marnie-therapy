<?php
/**
 * Single blog post: header (date, title, featured image) followed by the
 * ACF flexible content sections that make up the body (see
 * inc/acf-fields.php and template-parts/blog-section-*.php).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" tabindex="-1">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article <?php post_class(); ?>>
			<header class="post-header">
				<div class="container container--narrow">
					<p class="section__eyebrow"><?php echo esc_html( get_the_date() ); ?></p>
					<h1><?php the_title(); ?></h1>
				</div>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="post-header__image">
						<?php
						the_post_thumbnail(
							'blog-feature-lg',
							array(
								'sizes'    => '100vw',
								'loading'  => 'eager',
								'decoding' => 'async',
								'alt'      => get_the_title(),
							)
						);
						?>
					</div>
				<?php endif; ?>
			</header>

			<?php if ( have_rows( 'post_sections' ) ) : ?>
				<?php
				while ( have_rows( 'post_sections' ) ) :
					the_row();
					$layout = get_row_layout();
					$path   = get_theme_file_path( 'template-parts/blog-section-' . $layout . '.php' );

					if ( file_exists( $path ) ) {
						include $path;
					}
				endwhile;
				?>
			<?php elseif ( get_the_content() ) : ?>
				<div class="container container--narrow section">
					<div class="prose"><?php the_content(); ?></div>
				</div>
			<?php endif; ?>

			<?php
			$prev_post = get_previous_post();
			$next_post = get_next_post();
			?>
			<?php if ( $prev_post || $next_post ) : ?>
				<nav class="post-nav container" aria-label="<?php esc_attr_e( 'More posts', 'marnie-therapy' ); ?>">
					<?php if ( $prev_post ) : ?>
						<a class="post-nav__link post-nav__link--prev" href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>">
							<span class="post-nav__label"><?php esc_html_e( '← Previous', 'marnie-therapy' ); ?></span>
							<span class="post-nav__title"><?php echo esc_html( get_the_title( $prev_post ) ); ?></span>
						</a>
					<?php endif; ?>
					<?php if ( $next_post ) : ?>
						<a class="post-nav__link post-nav__link--next" href="<?php echo esc_url( get_permalink( $next_post ) ); ?>">
							<span class="post-nav__label"><?php esc_html_e( 'Next →', 'marnie-therapy' ); ?></span>
							<span class="post-nav__title"><?php echo esc_html( get_the_title( $next_post ) ); ?></span>
						</a>
					<?php endif; ?>
				</nav>
			<?php endif; ?>
		</article>
		<?php
	endwhile;
	?>
</main>

<?php get_footer(); ?>
