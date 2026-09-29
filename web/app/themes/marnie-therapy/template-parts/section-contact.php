<?php
/**
 * Contact section (ACF flexible content layout: contact).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading  = get_sub_field( 'heading' ) ?: 'Get in Touch';
$intro    = get_sub_field( 'intro' );
$show_map = get_sub_field( 'show_map' );

$email        = get_field( 'contact_email', 'option' ) ?: 'marnietherapy@gmail.com';
$price        = get_field( 'session_price', 'option' ) ?: '£40';
$concessions  = get_field( 'concessions_note', 'option' );
$address      = get_field( 'practice_address', 'option' ) ?: "Bathwick\nBath, BA2 4DU";
$map_embed    = get_field( 'map_embed_url', 'option' );

if ( ! $map_embed ) {
	// Google's key-less embed endpoint: no WebGL dependency (unlike OSM's
	// current MapLibre embed), so it degrades gracefully on older browsers.
	$map_embed = 'https://www.google.com/maps?q=' . rawurlencode( 'Bath Abbey, Bath BA2 4DU' ) . '&output=embed';
}
?>
<section class="section section--alt" id="contact" aria-labelledby="contact-heading">
	<div class="container">
		<h2 id="contact-heading"><?php echo esc_html( $heading ); ?></h2>

		<?php if ( $intro ) : ?>
			<p class="section__lede"><?php echo esc_html( $intro ); ?></p>
		<?php endif; ?>

		<div class="contact">
			<div>
				<dl class="contact__details">
					<div>
						<dt><?php esc_html_e( 'Email', 'marnie-therapy' ); ?></dt>
						<dd><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></dd>
					</div>
					<div>
						<dt><?php esc_html_e( 'Session fee', 'marnie-therapy' ); ?></dt>
						<dd>
							<?php echo esc_html( $price ); ?> <?php esc_html_e( 'per session', 'marnie-therapy' ); ?>
							<?php if ( $concessions ) : ?>
								— <?php echo esc_html( $concessions ); ?>
							<?php endif; ?>
						</dd>
					</div>
					<div>
						<dt><?php esc_html_e( 'Location', 'marnie-therapy' ); ?></dt>
						<dd><?php echo nl2br( esc_html( $address ) ); ?></dd>
					</div>
				</dl>

				<p>
					<a class="btn btn--primary" href="mailto:<?php echo esc_attr( $email ); ?>">
						<?php esc_html_e( 'Email Marnie to book a first session', 'marnie-therapy' ); ?>
					</a>
				</p>
			</div>

			<?php if ( $show_map ) : ?>
				<div class="contact__map">
					<iframe
						src="<?php echo esc_url( $map_embed ); ?>"
						title="<?php esc_attr_e( 'Map showing the location of Marnie Therapy in Bath', 'marnie-therapy' ); ?>"
						loading="lazy"
					></iframe>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
