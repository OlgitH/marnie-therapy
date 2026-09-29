<?php
/**
 * Full column blog post section (ACF flexible content layout: full_col).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = get_sub_field( 'heading' );
$content = get_sub_field( 'content' );
?>
<section class="section blog-section blog-section--full">
	<div class="container">
		<?php if ( $heading ) : ?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php if ( $content ) : ?>
			<div class="prose"><?php echo wp_kses_post( $content ); ?></div>
		<?php endif; ?>
	</div>
</section>
