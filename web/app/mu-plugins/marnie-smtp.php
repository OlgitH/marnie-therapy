<?php
/**
 * Plugin Name: Marnie SMTP
 * Description: Sends all wp_mail() (contact form, password resets) through Brevo SMTP. Credentials come from .env.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Without credentials, leave WordPress's default mail behaviour alone.
if ( ! defined( 'BREVO_SMTP_LOGIN' ) || ! BREVO_SMTP_LOGIN || ! defined( 'BREVO_SMTP_KEY' ) || ! BREVO_SMTP_KEY ) {
	return;
}

add_action(
	'phpmailer_init',
	function ( $phpmailer ) {
		$phpmailer->isSMTP();
		$phpmailer->Host       = 'smtp-relay.brevo.com';
		$phpmailer->Port       = 587;
		$phpmailer->SMTPSecure = 'tls';
		$phpmailer->SMTPAuth   = true;
		$phpmailer->Username   = BREVO_SMTP_LOGIN;
		$phpmailer->Password   = BREVO_SMTP_KEY;
	}
);

// Brevo only relays for verified senders, so force the From address.
if ( defined( 'MAIL_FROM_ADDRESS' ) && MAIL_FROM_ADDRESS ) {
	add_filter( 'wp_mail_from', fn() => MAIL_FROM_ADDRESS );
	add_filter( 'wp_mail_from_name', fn() => defined( 'MAIL_FROM_NAME' ) && MAIL_FROM_NAME ? MAIL_FROM_NAME : 'Marnie Therapy' );
}

// Surface SMTP failures in the PHP error log instead of failing silently.
add_action(
	'wp_mail_failed',
	function ( $error ) {
		error_log( 'wp_mail failed: ' . $error->get_error_message() );
	}
);
