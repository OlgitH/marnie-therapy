<?php
/**
 * Hero section (ACF flexible content layout: hero).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading      = get_sub_field( 'heading' ) ?: 'Marnie Therapy';
$name_line    = get_sub_field( 'name_line' ) ?: 'Marnie Kavanagh';
$name_position = get_sub_field( 'name_position' ) ?: 'before';
$subheading   =get_sub_field( 'subheading' );
$quote_text   = get_sub_field( 'quote_text' );
$quote_author = get_sub_field( 'quote_author' );
$background   = get_sub_field( 'background_image' ); // attachment ID
$cta_text     = get_sub_field( 'cta_text' ) ?: __( 'Get in touch', 'marnie-therapy' );
$second_cta   = get_sub_field( 'secondary_cta_text' ) ?: __( 'Learn about therapy with me', 'marnie-therapy' );
$second_short = get_sub_field( 'secondary_cta_mobile_text' ) ?: $second_cta;
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
		<?php if ( $name_line && 'after' !== $name_position ) : ?>
			<p class="hero__name"><?php echo esc_html( $name_line ); ?></p>
		<?php endif; ?>

		<h1 id="hero-heading"><?php echo nl2br( esc_html( $heading ) ); ?></h1>

		<?php if ( $name_line && 'after' === $name_position ) : ?>
			<p class="hero__name hero__name--after"><?php echo esc_html( $name_line ); ?></p>
		<?php endif; ?>

		<?php if ( $subheading ) : ?>
			<p class="hero__subheading"><?php echo nl2br( esc_html( $subheading ) ); ?></p>
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
			<a class="btn btn--outline" href="#therapy">
				<span class="hero__btn-full"><?php echo esc_html( $second_cta ); ?></span>
				<span class="hero__btn-short"><?php echo esc_html( $second_short ); ?></span>
			</a>
		</div>
	</div>
</section>
