<?php
/**
 * 404 template.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" tabindex="-1">
	<div class="container section container--narrow">
		<h1><?php esc_html_e( 'Page not found', 'marnie-therapy' ); ?></h1>
		<p><?php esc_html_e( "Sorry, that page doesn't exist. You can head back to the home page below.", 'marnie-therapy' ); ?></p>
		<p><a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'marnie-therapy' ); ?></a></p>
	</div>
</main>

<?php get_footer(); ?>
