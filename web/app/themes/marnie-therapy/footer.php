<?php
/**
 * Footer: contact recap, accreditation logos, legal links.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact_email = get_field( 'contact_email', 'option' ) ?: 'marnietherapy@gmail.com';
$footer_note   = get_field( 'footer_note', 'option' );
$ukcp_logo     = get_field( 'ukcp_logo', 'option' );
$bcpc_logo     = get_field( 'bcpc_logo', 'option' );
?>
	<footer class="site-footer" role="contentinfo">
		<div class="container site-footer__grid">
			<div>
				<p class="site-branding__name" style="color:#fff;"><?php bloginfo( 'name' ); ?></p>
				<p><?php esc_html_e( 'Relational psychotherapy in Bath — in person and online.', 'marnie-therapy' ); ?></p>
				<p>
					<a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a>
				</p>
				<?php if ( $ukcp_logo || $bcpc_logo ) : ?>
					<div class="site-footer__logos">
						<?php if ( $ukcp_logo ) : ?>
							<img src="<?php echo esc_url( $ukcp_logo['sizes']['thumbnail'] ?? $ukcp_logo['url'] ); ?>" alt="<?php echo esc_attr( $ukcp_logo['alt'] ?: 'UKCP — UK Council for Psychotherapy member' ); ?>" width="120" height="48" loading="lazy" />
						<?php endif; ?>
						<?php if ( $bcpc_logo ) : ?>
							<img src="<?php echo esc_url( $bcpc_logo['sizes']['thumbnail'] ?? $bcpc_logo['url'] ); ?>" alt="<?php echo esc_attr( $bcpc_logo['alt'] ?: 'Bath Centre for Counselling and Psychotherapy' ); ?>" width="120" height="48" loading="lazy" />
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<div>
				<h2 class="visually-hidden"><?php esc_html_e( 'Site navigation', 'marnie-therapy' ); ?></h2>
				<ul class="site-footer__nav-list">
					<li><a href="#therapy"><?php esc_html_e( 'Therapy', 'marnie-therapy' ); ?></a></li>
					<li><a href="#about"><?php esc_html_e( 'About Marnie', 'marnie-therapy' ); ?></a></li>
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
