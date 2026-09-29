<?php
/**
 * Theme support, assets, and navigation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'marnie-therapy', get_template_directory() . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'responsive-embeds' );

		register_nav_menus(
			array(
				'primary' => __( 'Primary Navigation', 'marnie-therapy' ),
				'footer'  => __( 'Footer Navigation', 'marnie-therapy' ),
			)
		);
	}
);

add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'marnie-therapy-fonts',
			'https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&display=swap',
			array(),
			null
		);

		wp_enqueue_style( 'marnie-therapy-style', get_stylesheet_uri(), array( 'marnie-therapy-fonts' ), MARNIE_THEME_VERSION );

		wp_enqueue_script(
			'marnie-therapy-main',
			get_theme_file_uri( 'assets/js/main.js' ),
			array(),
			MARNIE_THEME_VERSION,
			true
		);
	}
);

/**
 * Blog posts are authored with the "Post Content" flexible content field
 * (see inc/acf-fields.php) rather than the block editor, so the standard
 * editor box would just be a dead, unused UI element on the edit screen.
 */
add_action(
	'init',
	function () {
		remove_post_type_support( 'post', 'editor' );
	}
);

add_filter(
	'use_block_editor_for_post_type',
	function ( $use_block_editor, $post_type ) {
		if ( 'post' === $post_type ) {
			return false;
		}
		return $use_block_editor;
	},
	10,
	2
);

/**
 * Preconnect to Google Fonts so the stylesheet request above doesn't pay
 * a full DNS+TLS round trip before it can start.
 */
add_action(
	'wp_head',
	function () {
		echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
		echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
	},
	1
);

/**
 * Remove the default admin bar top margin issue caused by the sticky header,
 * and keep the skip link + sticky header from overlapping the WP toolbar.
 */
add_action(
	'wp_head',
	function () {
		if ( is_admin_bar_showing() ) {
			echo '<style>.site-header{top:32px}@media (max-width:782px){.site-header{top:46px}}</style>';
		}
	}
);

/**
 * Allow SVG uploads (e.g. a vector site logo via Customizer > Site
 * Identity). WordPress blocks SVG by default because an unsanitized SVG
 * can carry inline <script>/event-handler XSS; restricting this to
 * administrators keeps that risk limited to the one role that can already
 * install plugins and edit theme files, so it's not a meaningful privilege
 * escalation on a small single-admin site like this one.
 */
add_filter(
	'upload_mimes',
	function ( $mimes ) {
		if ( current_user_can( 'manage_options' ) ) {
			$mimes['svg'] = 'image/svg+xml';
		}
		return $mimes;
	}
);

add_filter(
	'wp_check_filetype_and_ext',
	function ( $data, $file, $filename, $mimes ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			return $data;
		}

		$filetype = wp_check_filetype( $filename, $mimes );

		if ( 'svg' === $filetype['ext'] ) {
			$data['ext']             = 'svg';
			$data['type']            = 'image/svg+xml';
			$data['proper_filename'] = $filename;
		}

		return $data;
	},
	10,
	4
);
