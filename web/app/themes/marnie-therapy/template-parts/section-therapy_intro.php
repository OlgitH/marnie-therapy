<?php
/**
 * Therapy introduction section (ACF flexible content layout: therapy_intro).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = get_sub_field( 'heading' ) ?: 'Therapy';
$content = get_sub_field( 'content' );
$image   = get_sub_field( 'image' ); // attachment ID
$zoom    = (int) get_sub_field( 'image_zoom' ) ?: 100;
?>
<section class="section" id="therapy" aria-labelledby="therapy-heading">
	<div class="container">
		<h2 id="therapy-heading"><?php echo esc_html( $heading ); ?></h2>

		<div class="therapy-intro<?php echo $image ? '' : ' therapy-intro--no-image'; ?>">
			<div>
				<?php if ( $content ) : ?>
					<div class="prose"><?php echo wp_kses_post( $content ); ?></div>
				<?php endif; ?>
			</div>

			<?php if ( $image ) : ?>
				<div class="therapy-intro__image" style="--photo-zoom: <?php echo esc_attr( max( 50, $zoom ) / 100 ); ?>">
					<?php
					// Fixed column on desktop, full-width below the text on
					// mobile (matches the .therapy-intro grid breakpoint in
					// style.css) — the sizes attribute tells the browser
					// exactly how large this will actually render, so it
					// picks the smallest sufficient file from the
					// about-sm..about-lg family.
					$image_alt = get_post_meta( $image, '_wp_attachment_image_alt', true );
					echo wp_get_attachment_image(
						$image,
						'large', // uncropped, so the whole room shows (about-lg is hard-cropped to 4:5)
						false,
						array(
							'alt'      => $image_alt ? $image_alt : '',
							'sizes'    => '(min-width: 56rem) 22rem, min(100vw, 28rem)',
							'loading'  => 'eager',
							'decoding' => 'async',
						)
					);
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
