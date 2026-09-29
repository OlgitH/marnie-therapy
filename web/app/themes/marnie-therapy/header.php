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
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="site-branding__link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<svg class="site-branding__mark" viewBox="0 0 100 100" role="img" aria-hidden="true" focusable="false">
						<path fill="#e0a84d" d="M50 38c-6-14-24-24-36-16-11 8-9 26 6 32 10 4 22 2 30-6 8 8 20 10 30 6 15-6 17-24 6-32-12-8-30 2-36 16z"/>
						<circle cx="50" cy="40" r="4" fill="#46593f"/>
					</svg>
					<span class="site-branding__name">Marnie Therapy</span>
				</a>
			<?php endif; ?>
		</div>

		<button
			type="button"
			class="nav-toggle"
			aria-expanded="false"
			aria-controls="primary-navigation"
		>
			<span class="visually-hidden"><?php esc_html_e( 'Menu', 'marnie-therapy' ); ?></span>
			<span aria-hidden="true">☰</span>
		</button>

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
