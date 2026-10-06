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
$price_suffix = get_field( 'session_price_suffix', 'option' );
$price_suffix = ( false === $price_suffix || null === $price_suffix ) ? 'per session' : $price_suffix;
$concessions  = get_field( 'concessions_note', 'option' );
$address      = get_field( 'practice_address', 'option' ) ?: "Bathwick\nBath, BA2 4DU";
$map_embed    = get_field( 'map_embed_url', 'option' );
$ukcp_logo    = get_field( 'ukcp_logo', 'option' );
$bcpc_logo    = get_field( 'bcpc_logo', 'option' );

if ( ! $map_embed ) {
	// Google's key-less embed endpoint: no WebGL dependency (unlike OSM's
	// current MapLibre embed), so it degrades gracefully on older browsers.
	$map_embed = 'https://www.google.com/maps?q=' . rawurlencode( 'BA2 4DU, United Kingdom' ) . '&output=embed';
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
							<?php echo esc_html( trim( $price . ' ' . $price_suffix ) ); ?>
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

				<?php
				$contact_status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : '';
				$status_notices = array(
					'sent'    => __( 'Thank you. Your message has been sent and I will be in touch soon.', 'marnie-therapy' ),
					'invalid' => __( 'Please add your name, a valid email address and a message, and tick the box to agree to be contacted.', 'marnie-therapy' ),
					'error'   => sprintf(
						/* translators: %s: email address. */
						__( 'Sorry, your message could not be sent. Please email %s directly.', 'marnie-therapy' ),
						$email
					),
				);
				?>

				<?php if ( isset( $status_notices[ $contact_status ] ) ) : ?>
					<p class="form-notice form-notice--<?php echo esc_attr( $contact_status ); ?>" role="status">
						<?php echo esc_html( $status_notices[ $contact_status ] ); ?>
					</p>
				<?php endif; ?>

				<?php if ( 'sent' !== $contact_status ) : ?>
					<h3 class="contact__form-heading"><?php esc_html_e( 'Send an enquiry', 'marnie-therapy' ); ?></h3>

					<form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<input type="hidden" name="action" value="<?php echo esc_attr( MARNIE_CONTACT_ACTION ); ?>" />
						<?php wp_nonce_field( MARNIE_CONTACT_ACTION, 'marnie_contact_nonce' ); ?>

						<p class="contact-form__hp" aria-hidden="true">
							<label>
								<?php esc_html_e( 'Leave this field empty', 'marnie-therapy' ); ?>
								<input type="text" name="marnie_website" tabindex="-1" autocomplete="off" />
							</label>
						</p>

						<div class="contact-form__row">
							<label class="contact-form__field">
								<span><?php esc_html_e( 'Name', 'marnie-therapy' ); ?> <abbr title="<?php esc_attr_e( 'required', 'marnie-therapy' ); ?>">*</abbr></span>
								<input type="text" name="name" autocomplete="name" required />
							</label>

							<label class="contact-form__field">
								<span><?php esc_html_e( 'Email', 'marnie-therapy' ); ?> <abbr title="<?php esc_attr_e( 'required', 'marnie-therapy' ); ?>">*</abbr></span>
								<input type="email" name="email" autocomplete="email" required />
							</label>
						</div>

						<label class="contact-form__field">
							<span><?php esc_html_e( 'Phone (optional)', 'marnie-therapy' ); ?></span>
							<input type="tel" name="phone" autocomplete="tel" />
						</label>

						<label class="contact-form__field">
							<span><?php esc_html_e( 'Message', 'marnie-therapy' ); ?> <abbr title="<?php esc_attr_e( 'required', 'marnie-therapy' ); ?>">*</abbr></span>
							<textarea name="message" rows="6" required></textarea>
						</label>

						<label class="contact-form__consent">
							<input type="checkbox" name="consent" value="1" required />
							<span><?php esc_html_e( 'I agree for the details I have given to be used to reply to this enquiry.', 'marnie-therapy' ); ?></span>
						</label>

						<p>
							<button type="submit" class="btn btn--primary"><?php esc_html_e( 'Send message', 'marnie-therapy' ); ?></button>
						</p>
					</form>
				<?php endif; ?>
			</div>

			<?php if ( $show_map || $ukcp_logo || $bcpc_logo ) : ?>
				<div class="contact__aside">
					<?php if ( $show_map ) : ?>
						<div class="contact__map">
							<iframe
								src="<?php echo esc_url( $map_embed ); ?>"
								title="<?php esc_attr_e( 'Map showing the location of Marnie Therapy in Bath', 'marnie-therapy' ); ?>"
								loading="lazy"
							></iframe>
						</div>
					<?php endif; ?>

					<?php if ( $ukcp_logo || $bcpc_logo ) : ?>
						<div class="contact__logos">
							<?php if ( $ukcp_logo ) : ?>
								<img src="<?php echo esc_url( $ukcp_logo['sizes']['medium'] ?? $ukcp_logo['url'] ); ?>" alt="<?php echo esc_attr( $ukcp_logo['alt'] ?: 'UKCP — UK Council for Psychotherapy member' ); ?>" width="120" height="48" loading="lazy" />
							<?php endif; ?>
							<?php if ( $bcpc_logo ) : ?>
								<img src="<?php echo esc_url( $bcpc_logo['sizes']['medium'] ?? $bcpc_logo['url'] ); ?>" alt="<?php echo esc_attr( $bcpc_logo['alt'] ?: 'Bath Centre for Counselling and Psychotherapy' ); ?>" width="120" height="48" loading="lazy" />
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
