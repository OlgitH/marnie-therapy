<?php
/**
 * ACF options pages and field group registration.
 *
 * Content is code-defined (local field groups) so the site's structure is
 * version-controlled, while every value stays editable from wp-admin under
 * Home Page Content / Site Settings — no template edits needed to update
 * copy, images, or FAQ items.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'acf/init',
	function () {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		acf_add_options_page(
			array(
				'page_title' => __( 'Home Page Content', 'marnie-therapy' ),
				'menu_title' => __( 'Home Page', 'marnie-therapy' ),
				'menu_slug'  => 'acf-options-home',
				'capability' => 'edit_posts',
				'icon_url'   => 'dashicons-admin-home',
				'position'   => 3,
			)
		);

		acf_add_options_page(
			array(
				'page_title' => __( 'Site Settings', 'marnie-therapy' ),
				'menu_title' => __( 'Site Settings', 'marnie-therapy' ),
				'menu_slug'  => 'acf-options-site-settings',
				'capability' => 'manage_options',
				'icon_url'   => 'dashicons-admin-generic',
				'position'   => 60,
			)
		);
	}
);

add_action( 'acf/include_fields', 'marnie_register_home_sections_fields' );

function marnie_register_home_sections_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_mt_home_sections',
			'title'    => 'Home Page Sections',
			'fields'   => array(
				array(
					'key'           => 'field_mt_home_sections',
					'label'         => 'Page Sections',
					'name'          => 'home_sections',
					'type'          => 'flexible_content',
					'instructions'  => 'Add, remove, and reorder the sections that make up the home page.',
					'button_label'  => 'Add Section',
					'layouts'       => array(
						'layout_mt_hero'          => array(
							'key'        => 'layout_mt_hero',
							'name'       => 'hero',
							'label'      => 'Hero',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'           => 'field_mt_hero_heading',
									'label'         => 'Heading',
									'name'          => 'heading',
									'type'          => 'textarea',
									'rows'          => 2,
									'instructions'  => 'Press Enter where the second line should start on phones (e.g. Relational Psychotherapist, then a new line: in Bath). On larger screens it shows on one line.',
									'default_value' => 'Marnie Therapy',
								),
								array(
									'key'           => 'field_mt_hero_name_line',
									'label'         => 'Name Line',
									'name'          => 'name_line',
									'type'          => 'text',
									'instructions'  => 'Shown under the heading, e.g. Marnie Kavanagh.',
									'default_value' => 'Marnie Kavanagh',
								),
								array(
									'key'   => 'field_mt_hero_subheading',
									'label' => 'Subheading',
									'name'  => 'subheading',
									'type'  => 'textarea',
									'rows'  => 2,
								),
								array(
									'key'   => 'field_mt_hero_quote_text',
									'label' => 'Quote',
									'name'  => 'quote_text',
									'type'  => 'textarea',
									'rows'  => 2,
								),
								array(
									'key'   => 'field_mt_hero_quote_author',
									'label' => 'Quote Author',
									'name'  => 'quote_author',
									'type'  => 'text',
								),
								array(
									'key'           => 'field_mt_hero_background',
									'label'         => 'Backdrop Photo',
									'name'          => 'background_image',
									'type'          => 'image',
									'return_format' => 'id',
									'preview_size'  => 'medium',
									'instructions'  => 'Calming backdrop photo (e.g. sunlit woodland). Falls back to a soft gradient if left empty. Upload landscape, ideally 2000px+ wide — max 8MB, and WordPress will automatically create smaller optimised versions for phones and tablets.',
								),
								array(
									'key'   => 'field_mt_hero_cta_text',
									'label' => 'Button Text',
									'name'  => 'cta_text',
									'type'  => 'text',
									'default_value' => 'Get in touch',
								),
								array(
									'key'           => 'field_mt_hero_secondary_cta_text',
									'label'         => 'Second Button Text',
									'name'          => 'secondary_cta_text',
									'type'          => 'text',
									'default_value' => 'Learn about therapy with me',
								),
								array(
									'key'          => 'field_mt_hero_secondary_cta_mobile_text',
									'label'        => 'Second Button Text (Phones)',
									'name'         => 'secondary_cta_mobile_text',
									'type'         => 'text',
									'instructions' => 'Shorter text shown on phones, e.g. My therapy. Leave empty to use the text above.',
								),
							),
						),
						'layout_mt_therapy_intro' => array(
							'key'        => 'layout_mt_therapy_intro',
							'name'       => 'therapy_intro',
							'label'      => 'Therapy Introduction',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'   => 'field_mt_therapy_heading',
									'label' => 'Heading',
									'name'  => 'heading',
									'type'  => 'text',
									'default_value' => 'Therapy',
								),
								array(
									'key'   => 'field_mt_therapy_content',
									'label' => 'Content',
									'name'  => 'content',
									'type'  => 'wysiwyg',
									'tabs'  => 'visual',
									'media_upload' => 0,
									'toolbar' => 'basic',
								),
								array(
									'key'           => 'field_mt_therapy_image',
									'label'         => 'Image',
									'name'          => 'image',
									'type'          => 'image',
									'return_format' => 'id',
									'preview_size'  => 'medium',
									'instructions'  => 'Optional image shown beside the text. Upload a tall portrait photo, ideally at least 1200px tall — max 8MB, and WordPress will automatically create smaller optimised versions for phones and tablets.',
								),
							),
						),
						'layout_mt_about'         => array(
							'key'        => 'layout_mt_about',
							'name'       => 'about',
							'label'      => 'About Me',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'   => 'field_mt_about_heading',
									'label' => 'Heading',
									'name'  => 'heading',
									'type'  => 'text',
									'default_value' => 'About Me',
								),
								array(
									'key'           => 'field_mt_about_photo',
									'label'         => 'Photo',
									'name'          => 'photo',
									'type'          => 'image',
									'return_format' => 'id',
									'preview_size'  => 'medium',
									'instructions'  => 'Portrait photo of Marnie. Upload at least 1200px tall — max 8MB, and WordPress will automatically create smaller optimised versions for mobile.',
								),
								array(
									'key'     => 'field_mt_about_content',
									'label'   => 'Bio',
									'name'    => 'content',
									'type'    => 'wysiwyg',
									'tabs'    => 'visual',
									'media_upload' => 0,
									'toolbar' => 'basic',
								),
							),
						),
						'layout_mt_faq'           => array(
							'key'        => 'layout_mt_faq',
							'name'       => 'faq',
							'label'      => 'FAQ',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'   => 'field_mt_faq_heading',
									'label' => 'Heading',
									'name'  => 'heading',
									'type'  => 'text',
									'default_value' => 'Frequently Asked Questions',
								),
								array(
									'key'           => 'field_mt_faq_photo_1',
									'label'         => 'Photo 1 (top)',
									'name'          => 'photo_1',
									'type'          => 'image',
									'return_format' => 'id',
									'preview_size'  => 'medium',
									'instructions'  => 'Shown beside the questions, above Photo 2. Max 8MB.',
								),
								array(
									'key'           => 'field_mt_faq_photo_2',
									'label'         => 'Photo 2 (bottom)',
									'name'          => 'photo_2',
									'type'          => 'image',
									'return_format' => 'id',
									'preview_size'  => 'medium',
									'instructions'  => 'Shown beside the questions, below Photo 1. Max 8MB.',
								),
								array(
									'key'          => 'field_mt_faq_items',
									'label'        => 'Questions',
									'name'         => 'items',
									'type'         => 'repeater',
									'layout'       => 'block',
									'button_label' => 'Add Question',
									'sub_fields'   => array(
										array(
											'key'   => 'field_mt_faq_item_question',
											'label' => 'Question',
											'name'  => 'question',
											'type'  => 'text',
										),
										array(
											'key'     => 'field_mt_faq_item_answer',
											'label'   => 'Answer',
											'name'    => 'answer',
											'type'    => 'wysiwyg',
											'tabs'    => 'visual',
											'media_upload' => 0,
											'toolbar' => 'basic',
										),
									),
								),
							),
						),
						'layout_mt_contact'       => array(
							'key'        => 'layout_mt_contact',
							'name'       => 'contact',
							'label'      => 'Contact',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'   => 'field_mt_contact_heading',
									'label' => 'Heading',
									'name'  => 'heading',
									'type'  => 'text',
									'default_value' => 'Get in Touch',
								),
								array(
									'key'   => 'field_mt_contact_intro',
									'label' => 'Intro',
									'name'  => 'intro',
									'type'  => 'textarea',
									'rows'  => 3,
								),
								array(
									'key'           => 'field_mt_contact_show_map',
									'label'         => 'Show Map',
									'name'          => 'show_map',
									'type'          => 'true_false',
									'default_value' => 1,
									'ui'            => 1,
								),
							),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-home',
					),
				),
			),
		)
	);
}

add_action( 'acf/include_fields', 'marnie_register_post_content_fields' );

function marnie_register_post_content_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_mt_post_content',
			'title'    => 'Blog Post Content',
			'fields'   => array(
				array(
					'key'          => 'field_mt_post_sections',
					'label'        => 'Post Content',
					'name'         => 'post_sections',
					'type'         => 'flexible_content',
					'instructions' => 'Build the post body from these sections.',
					'button_label' => 'Add Section',
					'layouts'      => array(
						'layout_mt_post_full_col' => array(
							'key'        => 'layout_mt_post_full_col',
							'name'       => 'full_col',
							'label'      => 'Full Column',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'   => 'field_mt_post_full_col_heading',
									'label' => 'Heading',
									'name'  => 'heading',
									'type'  => 'text',
								),
								array(
									'key'          => 'field_mt_post_full_col_content',
									'label'        => 'Content',
									'name'         => 'content',
									'type'         => 'wysiwyg',
									'tabs'         => 'visual',
									'media_upload' => 1,
									'toolbar'      => 'standard',
								),
							),
						),
						'layout_mt_post_two_col'  => array(
							'key'        => 'layout_mt_post_two_col',
							'name'       => 'two_col',
							'label'      => 'Two Column',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'   => 'field_mt_post_two_col_heading',
									'label' => 'Heading',
									'name'  => 'heading',
									'type'  => 'text',
								),
								array(
									'key'           => 'field_mt_post_two_col_image',
									'label'         => 'Image',
									'name'          => 'image',
									'type'          => 'image',
									'return_format' => 'id',
									'preview_size'  => 'medium',
								),
								array(
									'key'           => 'field_mt_post_two_col_image_position',
									'label'         => 'Image Position',
									'name'          => 'image_position',
									'type'          => 'button_group',
									'choices'       => array(
										'left'  => 'Left',
										'right' => 'Right',
									),
									'default_value' => 'left',
									'layout'        => 'horizontal',
								),
								array(
									'key'          => 'field_mt_post_two_col_content',
									'label'        => 'Content',
									'name'         => 'content',
									'type'         => 'wysiwyg',
									'tabs'         => 'visual',
									'media_upload' => 0,
									'toolbar'      => 'basic',
								),
							),
						),
						'layout_mt_post_video'    => array(
							'key'        => 'layout_mt_post_video',
							'name'       => 'video',
							'label'      => 'Video',
							'display'    => 'block',
							'sub_fields' => array(
								array(
									'key'   => 'field_mt_post_video_heading',
									'label' => 'Heading',
									'name'  => 'heading',
									'type'  => 'text',
								),
								array(
									'key'          => 'field_mt_post_video_embed',
									'label'        => 'Video URL',
									'name'         => 'video_embed',
									'type'         => 'oembed',
									'instructions' => 'Paste a YouTube or Vimeo link.',
								),
								array(
									'key'   => 'field_mt_post_video_caption',
									'label' => 'Caption',
									'name'  => 'caption',
									'type'  => 'text',
								),
							),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'post',
					),
				),
			),
		)
	);
}

add_action( 'acf/include_fields', 'marnie_register_site_settings_fields' );

function marnie_register_site_settings_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_mt_site_settings',
			'title'    => 'Site Settings',
			'fields'   => array(
				array(
					'key'   => 'field_mt_settings_email',
					'label' => 'Contact Email',
					'name'  => 'contact_email',
					'type'  => 'email',
					'default_value' => 'marnietherapy@gmail.com',
				),
				array(
					'key'          => 'field_mt_settings_phone',
					'label'        => 'Contact Phone',
					'name'         => 'contact_phone',
					'type'         => 'text',
					'instructions' => 'Shown as a "Call" button in the site header. Leave empty to hide it. Enter as you want it displayed, e.g. 01225 123 456.',
				),
				array(
					'key'   => 'field_mt_settings_price',
					'label' => 'Session Price',
					'name'  => 'session_price',
					'type'  => 'text',
					'default_value' => '£40',
				),
				array(
					'key'           => 'field_mt_settings_price_suffix',
					'label'         => 'Session Price Text',
					'name'          => 'session_price_suffix',
					'type'          => 'text',
					'instructions'  => 'Shown after the price, e.g. "per session". Leave empty to show just the price.',
					'default_value' => 'per session',
				),
				array(
					'key'           => 'field_mt_settings_quote_text',
					'label'         => 'Closing Quote',
					'name'          => 'closing_quote_text',
					'type'          => 'textarea',
					'rows'          => 2,
					'instructions'  => 'Quote band shown just above the footer on the home page. Leave empty to hide it.',
					'default_value' => 'I am not what happened to me, I am what I choose to become.',
				),
				array(
					'key'           => 'field_mt_settings_quote_author',
					'label'         => 'Closing Quote Author',
					'name'          => 'closing_quote_author',
					'type'          => 'text',
					'default_value' => 'Carl Jung',
				),
				array(
					'key'   => 'field_mt_settings_concessions',
					'label' => 'Concessions Note',
					'name'  => 'concessions_note',
					'type'  => 'textarea',
					'rows'  => 2,
				),
				array(
					'key'   => 'field_mt_settings_address',
					'label' => 'Practice Address',
					'name'  => 'practice_address',
					'type'  => 'textarea',
					'rows'  => 3,
					'default_value' => "Bathwick\nBath, BA2 4DU",
				),
				array(
					'key'   => 'field_mt_settings_map_embed',
					'label' => 'Map Embed URL',
					'name'  => 'map_embed_url',
					'type'  => 'url',
					'instructions' => 'An OpenStreetMap or Google Maps embed URL for the practice location.',
				),
				array(
					'key'           => 'field_mt_settings_mobile_logo',
					'label'         => 'Mobile Logo',
					'name'          => 'mobile_logo',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'thumbnail',
					'instructions'  => 'Optional logo shown in the header on all screen sizes instead of the main site logo (Customizer). Best as a square or wide-but-short mark — leave empty to keep using the main logo.',
				),
				array(
					'key'           => 'field_mt_settings_ukcp_logo',
					'label'         => 'UKCP Logo',
					'name'          => 'ukcp_logo',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'thumbnail',
				),
				array(
					'key'           => 'field_mt_settings_bcpc_logo',
					'label'         => 'BCPC Logo',
					'name'          => 'bcpc_logo',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'thumbnail',
				),
				array(
					'key'   => 'field_mt_settings_meta_description',
					'label' => 'SEO Meta Description',
					'name'  => 'meta_description',
					'type'  => 'textarea',
					'rows'  => 3,
					'instructions' => 'Shown in Google search results and social previews. Aim for 150–160 characters.',
				),
				array(
					'key'           => 'field_mt_settings_og_image',
					'label'         => 'Social Share Image',
					'name'          => 'og_image',
					'type'          => 'image',
					'return_format' => 'array',
					'preview_size'  => 'medium',
				),
				array(
					'key'           => 'field_mt_settings_footer_description',
					'label'         => 'Footer Description',
					'name'          => 'footer_description',
					'type'          => 'textarea',
					'rows'          => 3,
					'new_lines'     => '',
					'default_value' => 'Relational psychotherapy in Bath — in person and online.',
					'instructions'  => 'Short line shown under the logo in the footer.',
				),
				array(
					'key'   => 'field_mt_settings_footer_note',
					'label' => 'Footer Note',
					'name'  => 'footer_note',
					'type'  => 'text',
					'instructions' => 'e.g. registration or supervision note shown in the footer.',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'acf-options-site-settings',
					),
				),
			),
		)
	);
}
