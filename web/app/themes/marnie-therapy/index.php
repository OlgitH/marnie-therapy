<?php
/**
 * Fallback template (required by WordPress). This is a single-page
 * brochure site built on front-page.php; index.php only renders if a URL
 * doesn't match a more specific template.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" tabindex="-1">
	<div class="container section container--narrow">
		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article <?php post_class(); ?>>
					<h1><?php the_title(); ?></h1>
					<div class="prose"><?php the_content(); ?></div>
				</article>
				<?php
			endwhile;
			?>
		<?php else : ?>
			<h1><?php esc_html_e( 'Nothing found', 'marnie-therapy' ); ?></h1>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
