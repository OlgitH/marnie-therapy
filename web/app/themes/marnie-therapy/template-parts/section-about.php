<?php
/**
 * About Marnie section (ACF flexible content layout: about).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading   = get_sub_field( 'heading' ) ?: 'About Marnie';
$name_line = get_sub_field( 'name_line' );
$photo     = get_sub_field( 'photo' ); // attachment ID
$content   = get_sub_field( 'content' );
$areas     = get_sub_field( 'experience_areas' );
?>
<section class="section section--alt" id="about" aria-labelledby="about-heading">
	<div class="container">
		<h2 id="about-heading"><?php echo esc_html( $heading ); ?></h2>

		<div class="about">
			<div class="about__photo<?php echo $photo ? '' : ' about__photo--placeholder'; ?>">
				<?php if ( $photo ) : ?>
					<?php
					// Fixed ~20rem column on desktop, full-width card on mobile
					// (matches the .about grid breakpoint in style.css) — the
					// sizes attribute tells the browser exactly how large this
					// will actually render, so it picks the smallest sufficient
					// file from the about-sm..about-lg family.
					$photo_alt = get_post_meta( $photo, '_wp_attachment_image_alt', true );
					echo wp_get_attachment_image(
						$photo,
						'about-lg',
						false,
						array(
							'alt'      => $photo_alt ? $photo_alt : ( $name_line ? $name_line : 'Portrait of Marnie' ),
							'sizes'    => '(min-width: 56rem) 20rem, 100vw',
							'loading'  => 'lazy',
							'decoding' => 'async',
						)
					);
					?>
				<?php else : ?>
					<svg width="72" height="72" viewBox="0 0 100 100" aria-hidden="true" focusable="false">
						<path fill="#e0a84d" d="M50 38c-6-14-24-24-36-16-11 8-9 26 6 32 10 4 22 2 30-6 8 8 20 10 30 6 15-6 17-24 6-32-12-8-30 2-36 16z"/>
					</svg>
				<?php endif; ?>
			</div>

			<div>
				<?php if ( $name_line ) : ?>
					<h3><?php echo esc_html( $name_line ); ?></h3>
				<?php endif; ?>

				<?php if ( $content ) : ?>
					<div class="prose"><?php echo wp_kses_post( $content ); ?></div>
				<?php endif; ?>

				<?php if ( $areas ) : ?>
					<h4><?php esc_html_e( 'Areas of experience', 'marnie-therapy' ); ?></h4>
					<ul class="tag-list">
						<?php foreach ( $areas as $area ) : ?>
							<?php if ( ! empty( $area['label'] ) ) : ?>
								<li><?php echo esc_html( $area['label'] ); ?></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
