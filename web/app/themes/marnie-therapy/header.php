<?php
/**
 * Header: skip link, sticky site header, and primary navigation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="theme-color" content="#46593f" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'marnie-therapy' ); ?></a>

<header class="site-header">
	<div class="container site-header__inner">
		<?php $mobile_logo = get_field( 'mobile_logo', 'option' ); ?>
		<div class="site-branding<?php echo $mobile_logo ? ' has-mobile-logo' : ''; ?>">
			<?php if ( has_custom_logo() ) : ?>
				<span class="site-branding__desktop-logo">
					<?php the_custom_logo(); ?>
				</span>
			<?php else : ?>
				<a class="site-branding__link site-branding__desktop-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<svg class="site-branding__mark" viewBox="0 0 100 100" role="img" aria-hidden="true" focusable="false">
						<path fill="#e0a84d" d="M50 38c-6-14-24-24-36-16-11 8-9 26 6 32 10 4 22 2 30-6 8 8 20 10 30 6 15-6 17-24 6-32-12-8-30 2-36 16z"/>
						<circle cx="50" cy="40" r="4" fill="#46593f"/>
					</svg>
					<span class="site-branding__name">Marnie Therapy</span>
				</a>
			<?php endif; ?>

			<?php if ( $mobile_logo ) : ?>
				<a class="site-branding__link site-branding__mobile-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img
						src="<?php echo esc_url( $mobile_logo['url'] ); ?>"
						alt="<?php echo esc_attr( $mobile_logo['alt'] ?: get_bloginfo( 'name' ) ); ?>"
						width="<?php echo esc_attr( $mobile_logo['width'] ); ?>"
						height="<?php echo esc_attr( $mobile_logo['height'] ); ?>"
					/>
				</a>
			<?php endif; ?>
		</div>

		<div class="site-header__actions">
			<?php
			$header_phone = get_field( 'contact_phone', 'option' );
			$header_call_href  = $header_phone ? 'tel:' . preg_replace( '/[^+\d]/', '', $header_phone ) : '#contact';
			$header_call_label = $header_phone
				? sprintf(
					/* translators: %s: phone number */
					__( 'Call %s', 'marnie-therapy' ),
					$header_phone
				)
				: __( 'Book session', 'marnie-therapy' );
			?>
			<a class="btn btn--call" href="<?php echo esc_attr( $header_call_href ); ?>">
				<?php echo esc_html( $header_call_label ); ?>
			</a>

			<button
				type="button"
				class="nav-toggle"
				aria-expanded="false"
				aria-controls="primary-navigation"
			>
				<span class="visually-hidden"><?php esc_html_e( 'Menu', 'marnie-therapy' ); ?></span>
				<span class="nav-toggle__bars" aria-hidden="true">
					<span class="nav-toggle__bar nav-toggle__bar--1"></span>
					<span class="nav-toggle__bar nav-toggle__bar--2"></span>
					<span class="nav-toggle__bar nav-toggle__bar--3"></span>
				</span>
			</button>
		</div>

		<nav class="primary-nav" id="primary-navigation" aria-label="<?php esc_attr_e( 'Primary', 'marnie-therapy' ); ?>">
			<?php if ( has_nav_menu( 'primary' ) ) : ?>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'items_wrap'     => '<ul class="primary-nav__list">%3$s</ul>',
					)
				);
				?>
			<?php else : ?>
				<ul class="primary-nav__list">
					<li><a href="#therapy"><?php esc_html_e( 'Therapy', 'marnie-therapy' ); ?></a></li>
					<li><a href="#about"><?php esc_html_e( 'About Marnie', 'marnie-therapy' ); ?></a></li>
					<li><a href="#faq"><?php esc_html_e( 'FAQs', 'marnie-therapy' ); ?></a></li>
					<li><a href="#contact"><?php esc_html_e( 'Contact', 'marnie-therapy' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</nav>
	</div>
</header>
