<?php
/**
 * SEO: title, meta description, Open Graph, and local business schema.
 *
 * Targets the practice's core local search terms (relational therapist /
 * psychotherapist in Bath, trainee psychotherapist BCPC) without any SEO
 * plugin dependency.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter(
	'document_title_parts',
	function ( $title ) {
		if ( is_front_page() ) {
			$title['title']   = 'Marnie Therapy';
			$title['tagline']  = __( 'Relational Psychotherapist in Bath', 'marnie-therapy' );
		}

		return $title;
	}
);

function marnie_meta_description() {
	$description = function_exists( 'get_field' ) ? get_field( 'meta_description', 'option' ) : '';

	if ( empty( $description ) ) {
		$description = __( 'Marnie Kavanagh offers warm, relational psychotherapy in Bath for anxiety, trauma, grief and relationship difficulties, in person and online.', 'marnie-therapy' );
	}

	return trim( wp_strip_all_tags( $description ) );
}

add_action(
	'wp_head',
	function () {
		if ( ! is_front_page() ) {
			return;
		}

		$description = marnie_meta_description();
		$url         = home_url( '/' );
		$og_image    = function_exists( 'get_field' ) ? get_field( 'og_image', 'option' ) : null;

		echo "\n<!-- SEO: Marnie Therapy -->\n";
		printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $description ) );
		printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $url ) );

		printf( '<meta property="og:type" content="website" />' . "\n" );
		printf( '<meta property="og:site_name" content="Marnie Therapy" />' . "\n" );
		printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( 'Marnie Therapy — Relational Psychotherapist in Bath' ) );
		printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $description ) );
		printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $url ) );

		if ( ! empty( $og_image['url'] ) ) {
			printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $og_image['url'] ) );
		}

		printf( '<meta name="twitter:card" content="summary_large_image" />' . "\n" );

		marnie_local_business_schema();
	}
);

/**
 * JSON-LD structured data so search engines can surface Marnie Therapy as a
 * local psychotherapy practice in Bath (name, address, area served, price).
 */
function marnie_local_business_schema() {
	$email            = function_exists( 'get_field' ) ? get_field( 'contact_email', 'option' ) : 'marnietherapy@gmail.com';
	$address          = function_exists( 'get_field' ) ? get_field( 'practice_address', 'option' ) : "Bathwick\nBath, BA2 4DU";
	$price            = function_exists( 'get_field' ) ? get_field( 'session_price', 'option' ) : '£40';
	$address_lines    = array_filter( array_map( 'trim', explode( "\n", (string) $address ) ) );

	$schema = array(
		'@context'          => 'https://schema.org',
		'@type'             => 'ProfessionalService',
		'name'              => 'Marnie Therapy',
		'description'       => marnie_meta_description(),
		'url'               => home_url( '/' ),
		'email'             => $email ? $email : 'marnietherapy@gmail.com',
		'areaServed'        => 'Bath, UK',
		'priceRange'        => $price ? $price : '£40',
		'address'           => array(
			'@type'           => 'PostalAddress',
			'addressLocality' => 'Bath',
			'addressRegion'   => 'Somerset',
			'postalCode'      => 'BA2 4DU',
			'addressCountry'  => 'GB',
			'streetAddress'   => $address_lines ? implode( ', ', $address_lines ) : 'Bathwick, Bath',
		),
	);

	echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}
