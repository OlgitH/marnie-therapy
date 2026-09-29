<?php
/**
 * Video blog post section (ACF flexible content layout: video).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = get_sub_field( 'heading' );
$video   = get_sub_field( 'video_embed' ); // oEmbed HTML, or false
$caption = get_sub_field( 'caption' );
?>
<section class="section blog-section blog-section--video">
	<div class="container container--narrow">
		<?php if ( $heading ) : ?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<?php if ( $video ) : ?>
			<div class="video-embed"><?php echo $video; // ACF oEmbed HTML, built server-side by WordPress from an admin-supplied URL. ?></div>
		<?php endif; ?>
		<?php if ( $caption ) : ?>
			<p class="video-embed__caption"><?php echo esc_html( $caption ); ?></p>
		<?php endif; ?>
	</div>
</section>
