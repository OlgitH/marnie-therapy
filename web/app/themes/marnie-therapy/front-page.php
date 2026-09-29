<?php
/**
 * Front page: renders the ACF flexible content sections in order.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" tabindex="-1">
	<?php if ( have_rows( 'home_sections', 'option' ) ) : ?>
		<?php
		while ( have_rows( 'home_sections', 'option' ) ) :
			the_row();
			$layout = get_row_layout();
			$path   = get_theme_file_path( 'template-parts/section-' . $layout . '.php' );

			if ( file_exists( $path ) ) {
				include $path;
			}
		endwhile;
		?>
	<?php else : ?>
		<div class="container section">
			<p>
				<?php
				printf(
					/* translators: %s: link to the Home Page options screen. */
					esc_html__( 'No sections yet — add some under %s in wp-admin.', 'marnie-therapy' ),
					'<a href="' . esc_url( admin_url( 'admin.php?page=acf-options-home' ) ) . '">' . esc_html__( 'Home Page', 'marnie-therapy' ) . '</a>'
				);
				?>
			</p>
		</div>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
