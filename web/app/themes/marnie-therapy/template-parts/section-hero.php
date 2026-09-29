<?php
/**
 * Hero section (ACF flexible content layout: hero).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading      = get_sub_field( 'heading' ) ?: 'Marnie Therapy';
$subheading   = get_sub_field( 'subheading' );
$quote_text   = get_sub_field( 'quote_text' );
$quote_author = get_sub_field( 'quote_author' );
$background   = get_sub_field( 'background_image' ); // attachment ID
$cta_text     = get_sub_field( 'cta_text' ) ?: __( 'Get in touch', 'marnie-therapy' );
?>
<section class="hero" aria-labelledby="hero-heading">
	<div class="hero__media<?php echo $background ? '' : ' hero__media--placeholder'; ?>" aria-hidden="true">
		<?php if ( $background ) : ?>
			<?php
			// Full-bleed, above the fold: request the browser fetch it with
			// priority, and let srcset (built from the hero-sm..hero-xl
			// family) pick the file that actually matches the viewport
			// instead of always shipping the largest crop.
			echo wp_get_attachment_image(
				$background,
				'hero-xl',
				false,
				array(
					'alt'           => '',
					'sizes'         => '100vw',
					'fetchpriority' => 'high',
					'decoding'      => 'async',
				)
			);
			?>
		<?php endif; ?>
	</div>

	<div class="container hero__content">
		<h1 id="hero-heading"><?php echo esc_html( $heading ); ?></h1>

		<?php if ( $subheading ) : ?>
			<p class="hero__subheading"><?php echo esc_html( $subheading ); ?></p>
		<?php endif; ?>

		<?php if ( $quote_text ) : ?>
			<blockquote class="hero__quote">
				<p>&ldquo;<?php echo esc_html( $quote_text ); ?>&rdquo;</p>
				<?php if ( $quote_author ) : ?>
					<cite>&mdash; <?php echo esc_html( $quote_author ); ?></cite>
				<?php endif; ?>
			</blockquote>
		<?php endif; ?>

		<div class="hero__actions">
			<a class="btn btn--primary" href="#contact"><?php echo esc_html( $cta_text ); ?></a>
			<a class="btn btn--outline" href="#therapy"><?php esc_html_e( 'Learn about therapy with me', 'marnie-therapy' ); ?></a>
		</div>
	</div>
</section>
