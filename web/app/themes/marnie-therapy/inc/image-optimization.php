<?php
/**
 * Image size registration, upload format, upload size limits, and quality —
 * so a phone/DSLR photo dropped into the Hero or About field doesn't sit on
 * disk at full resolution, and the front end always serves the size that
 * actually matches the visitor's viewport rather than one fixed image.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Responsive size families. Each family shares one aspect ratio across
 * several widths, so wp_get_attachment_image() can build a real srcset —
 * a phone gets the ~600px version, a 4K monitor gets the ~2400px one,
 * instead of everyone downloading the largest crop.
 */
add_action(
	'after_setup_theme',
	function () {
		// Hero backdrop, 3:2, full-bleed above the fold.
		add_image_size( 'hero-sm', 600, 400, true );
		add_image_size( 'hero-md', 1200, 800, true );
		add_image_size( 'hero-lg', 1800, 1200, true );
		add_image_size( 'hero-xl', 2400, 1600, true );

		// About portrait, 4:5, capped at a fixed ~20rem column on desktop.
		add_image_size( 'about-sm', 400, 500, true );
		add_image_size( 'about-md', 800, 1000, true );
		add_image_size( 'about-lg', 1200, 1500, true );

		// Blog card thumbnail, 3:2, used in the blog grid.
		add_image_size( 'blog-card-sm', 480, 320, true );
		add_image_size( 'blog-card-md', 800, 533, true );
		add_image_size( 'blog-card-lg', 1200, 800, true );

		// Blog feature image, 16:9 — single post header and two-column sections.
		add_image_size( 'blog-feature-sm', 800, 450, true );
		add_image_size( 'blog-feature-md', 1200, 675, true );
		add_image_size( 'blog-feature-lg', 1800, 1013, true );
	}
);

add_filter(
	'image_size_names_choose',
	function ( $sizes ) {
		return array_merge(
			$sizes,
			array(
				'hero-xl'       => __( 'Hero (full width)', 'marnie-therapy' ),
				'about-lg'      => __( 'About portrait', 'marnie-therapy' ),
				'blog-card-lg'  => __( 'Blog card', 'marnie-therapy' ),
				'blog-feature-lg' => __( 'Blog feature (wide)', 'marnie-therapy' ),
			)
		);
	}
);

/**
 * WordPress's own safety net: any upload wider/taller than this gets scaled
 * down to this size before any sub-sizes are generated from it, so a 6000px
 * camera original never sits on disk at full resolution. Set to match our
 * largest registered crop (hero-xl, 2400px) so that crop is never upscaled.
 */
add_filter( 'big_image_size_threshold', fn() => 2400 );

/**
 * Drop the default WordPress sizes we never use. WordPress generates these
 * for every image regardless of theme; medium_large and the 1536/2048
 * "2x" sizes are the biggest unused disk cost on a small brochure site.
 * thumbnail/medium/large are kept — thumbnail for admin previews (incl.
 * the UKCP/BCPC logo fields), medium/large as sane options when inserting
 * an image into a WYSIWYG field (bio, FAQ answers).
 */
add_filter(
	'intermediate_image_sizes_advanced',
	function ( $sizes ) {
		unset( $sizes['medium_large'], $sizes['1536x1536'], $sizes['2048x2048'] );
		return $sizes;
	}
);

/**
 * Save generated sub-sizes as WebP rather than JPEG/PNG — smaller files at
 * equivalent visual quality, no plugin required. GD in the Docker image is
 * built with webp support already (see Dockerfile).
 */
add_filter(
	'image_editor_output_format',
	function ( $format ) {
		$format['image/jpeg'] = 'image/webp';
		$format['image/png']  = 'image/webp';
		return $format;
	}
);

/**
 * A slightly leaner compression than WordPress's default (82) — not
 * noticeable on photos at these display sizes, meaningfully smaller files.
 */
add_filter(
	'wp_editor_set_quality',
	function ( $quality, $mime_type ) {
		if ( in_array( $mime_type, array( 'image/jpeg', 'image/webp' ), true ) ) {
			return 78;
		}
		return $quality;
	},
	10,
	2
);

/**
 * Reject oversized image uploads in the admin with a clear, specific
 * message, rather than letting editors upload multi-MB camera originals
 * that WordPress would dutifully store and generate every size from. This
 * is a tighter, friendlier limit than the raw PHP upload_max_filesize
 * ceiling (see uploads.ini) — only images are capped, other file types
 * (e.g. a PDF) are unaffected.
 */
add_filter(
	'wp_handle_upload_prefilter',
	function ( $file ) {
		$max_bytes = 8 * MB_IN_BYTES;
		$is_image  = isset( $file['type'] ) && strpos( $file['type'], 'image/' ) === 0;

		if ( $is_image && $file['size'] > $max_bytes ) {
			$file['error'] = sprintf(
				/* translators: %s: maximum file size, e.g. "8 MB" */
				__( 'Images must be smaller than %s. Please resize or compress this photo before uploading — most phones let you choose a smaller export size, or use a free tool like squoosh.app.', 'marnie-therapy' ),
				size_format( $max_bytes )
			);
		}

		return $file;
	}
);
