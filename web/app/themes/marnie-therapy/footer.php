<?php
/**
 * Footer: contact recap, accreditation logos, legal links.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact_email = get_field( 'contact_email', 'option' ) ?: 'marnietherapy@gmail.com';
$footer_note   = get_field( 'footer_note', 'option' );

$quote_text = get_field( 'closing_quote_text', 'option' );
if ( false === $quote_text || null === $quote_text ) {
	$quote_text = 'I am not what happened to me, I am what I choose to become.';
}
$quote_author = get_field( 'closing_quote_author', 'option' );
if ( false === $quote_author || null === $quote_author ) {
	$quote_author = 'Carl Jung';
}
?>
	<?php if ( is_front_page() && $quote_text ) : ?>
		<section class="quote-band" aria-label="<?php esc_attr_e( 'Quote', 'marnie-therapy' ); ?>">
			<div class="container">
				<blockquote class="quote-band__quote">
					<p>&ldquo;<?php echo esc_html( $quote_text ); ?>&rdquo;</p>
					<?php if ( $quote_author ) : ?>
						<cite>&mdash; <?php echo esc_html( $quote_author ); ?></cite>
					<?php endif; ?>
				</blockquote>
			</div>
		</section>
	<?php endif; ?>

	<footer class="site-footer" role="contentinfo">
		<div class="container site-footer__grid">
			<div>
				<?php $footer_logo = get_field( 'mobile_logo', 'option' ); ?>
				<div class="site-footer__logo">
					<?php if ( $footer_logo ) : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
							<img
								src="<?php echo esc_url( $footer_logo['url'] ); ?>"
								alt="<?php echo esc_attr( $footer_logo['alt'] ?: get_bloginfo( 'name' ) ); ?>"
								width="<?php echo esc_attr( $footer_logo['width'] ); ?>"
								height="<?php echo esc_attr( $footer_logo['height'] ); ?>"
							>
						</a>
					<?php elseif ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php endif; ?>
				</div>
				<p><?php esc_html_e( 'Relational psychotherapy in Bath — in person and online.', 'marnie-therapy' ); ?></p>
				<p>
					<a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a>
				</p>
			</div>

			<div>
				<h2 class="visually-hidden"><?php esc_html_e( 'Site navigation', 'marnie-therapy' ); ?></h2>
				<ul class="site-footer__nav-list">
					<li><a href="#therapy"><?php esc_html_e( 'Therapy', 'marnie-therapy' ); ?></a></li>
					<li><a href="#about"><?php esc_html_e( 'About Me', 'marnie-therapy' ); ?></a></li>
					<li><a href="#faq"><?php esc_html_e( 'FAQs', 'marnie-therapy' ); ?></a></li>
					<li><a href="#contact"><?php esc_html_e( 'Contact', 'marnie-therapy' ); ?></a></li>
				</ul>
			</div>

			<div>
				<h2 class="visually-hidden"><?php esc_html_e( 'Legal', 'marnie-therapy' ); ?></h2>
				<ul class="site-footer__nav-list">
					<?php if ( has_nav_menu( 'footer' ) ) : ?>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer',
								'container'      => false,
								'items_wrap'     => '%3$s',
							)
						);
						?>
					<?php else : ?>
						<?php
						$privacy = get_page_by_path( 'privacy-policy' );
						$terms   = get_page_by_path( 'terms-of-service' );
						?>
						<?php if ( $privacy ) : ?>
							<li><a href="<?php echo esc_url( get_permalink( $privacy ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'marnie-therapy' ); ?></a></li>
						<?php endif; ?>
						<?php if ( $terms ) : ?>
							<li><a href="<?php echo esc_url( get_permalink( $terms ) ); ?>"><?php esc_html_e( 'Terms of Service', 'marnie-therapy' ); ?></a></li>
						<?php endif; ?>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="container site-footer__bottom">
			<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'marnie-therapy' ); ?></p>
			<?php if ( $footer_note ) : ?>
				<p><?php echo esc_html( $footer_note ); ?></p>
			<?php endif; ?>
		</div>
	</footer>

<?php wp_footer(); ?>
</body>
</html>
