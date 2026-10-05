<?php
/**
 * Marnie Therapy theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MARNIE_THEME_VERSION', '1.2.0' );

require_once get_theme_file_path( 'inc/setup.php' );
require_once get_theme_file_path( 'inc/image-optimization.php' );
require_once get_theme_file_path( 'inc/acf-fields.php' );
require_once get_theme_file_path( 'inc/seo.php' );
require_once get_theme_file_path( 'inc/contact-form.php' );
