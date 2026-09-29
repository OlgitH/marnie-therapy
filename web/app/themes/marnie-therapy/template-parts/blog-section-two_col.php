<?php
/**
 * Two column blog post section (ACF flexible content layout: two_col).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading  = get_sub_field( 'heading' );
$image    = get_sub_field( 'image' ); // attachment ID
$position = get_sub_field( 'image_position' ) ?: 'left';
$content  = get_sub_field( 'content' );
?>
<section class="section blog-section blog-section--two-col">
	<div class="container">
		<?php if ( $heading ) : ?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<div class="two-col two-col--image-<?php echo esc_attr( $position ); ?>">
			<?php if ( $image ) : ?>
				<div class="two-col__image">
					<?php
					$alt = get_post_meta( $image, '_wp_attachment_image_alt', true );
					echo wp_get_attachment_image(
						$image,
						'blog-feature-lg',
						false,
						array(
							'alt'      => $alt ? $alt : '',
							'sizes'    => '(min-width: 56rem) 50vw, 100vw',
							'loading'  => 'lazy',
							'decoding' => 'async',
						)
					);
					?>
				</div>
			<?php endif; ?>
			<?php if ( $content ) : ?>
				<div class="two-col__content prose"><?php echo wp_kses_post( $content ); ?></div>
			<?php endif; ?>
		</div>
	</div>
</section>
