<?php
/**
 * Contact form: submission handler.
 *
 * The form in template-parts/section-contact.php posts to admin-post.php.
 * Each submission is checked (nonce, honeypot, required fields) and then
 * emailed to the practice address from Site Settings. The visitor is sent
 * back to the contact section with a status flag for the notice.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const MARNIE_CONTACT_ACTION = 'marnie_contact_submit';

add_action( 'admin_post_nopriv_' . MARNIE_CONTACT_ACTION, 'marnie_handle_contact_form' );
add_action( 'admin_post_' . MARNIE_CONTACT_ACTION, 'marnie_handle_contact_form' );

/**
 * Redirect back to the contact section with a status flag.
 *
 * @param string $status One of: sent, invalid, error.
 */
function marnie_contact_redirect( $status ) {
	$base = wp_get_referer() ?: home_url( '/' );
	$url  = add_query_arg( 'contact', $status, remove_query_arg( 'contact', $base ) );

	wp_safe_redirect( $url . '#contact' );
	exit;
}

function marnie_handle_contact_form() {
	$nonce = isset( $_POST['marnie_contact_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['marnie_contact_nonce'] ) ) : '';

	if ( ! wp_verify_nonce( $nonce, MARNIE_CONTACT_ACTION ) ) {
		wp_die(
			esc_html__( 'Your session has expired. Please go back, refresh the page and try again.', 'marnie-therapy' ),
			esc_html__( 'Please try again', 'marnie-therapy' ),
			array( 'response' => 403 )
		);
	}

	// Honeypot: the field is hidden from people, so only bots fill it in.
	// Report success so the bot gets no hint that it was caught.
	if ( ! empty( $_POST['marnie_website'] ) ) {
		marnie_contact_redirect( 'sent' );
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
	$consent = ! empty( $_POST['consent'] );

	if ( '' === $name || ! is_email( $email ) || '' === $message || ! $consent ) {
		marnie_contact_redirect( 'invalid' );
	}

	$to = get_field( 'contact_email', 'option' ) ?: get_option( 'admin_email' );

	$subject = sprintf(
		/* translators: 1: site name, 2: sender's name. */
		__( '[%1$s] New enquiry from %2$s', 'marnie-therapy' ),
		get_bloginfo( 'name' ),
		$name
	);

	$lines = array(
		sprintf( __( 'Name: %s', 'marnie-therapy' ), $name ),
		sprintf( __( 'Email: %s', 'marnie-therapy' ), $email ),
		sprintf( __( 'Phone: %s', 'marnie-therapy' ), '' !== $phone ? $phone : __( 'Not given', 'marnie-therapy' ) ),
		'',
		__( 'Message:', 'marnie-therapy' ),
		$message,
	);

	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );
	$sent    = wp_mail( $to, $subject, implode( "\n", $lines ), $headers );

	marnie_contact_redirect( $sent ? 'sent' : 'error' );
}
